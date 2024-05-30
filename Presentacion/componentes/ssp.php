<?php

class SSP {
    /**
     * Create the data output array for the DataTables rows
     *
     * @param  array $columns Column information array
     * @param  array $data    Data from the SQL get
     * @return array          Formatted data in a row based format
     */
    static function data_output($columns, $data) {
        $out = array();

        for ($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = array();

            for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $column = $columns[$j];

                // Is there a formatter?
                if (isset($column['formatter'])) {
                    if (empty($column['db'])) {
                        $row[$column['dt']] = $column['formatter']($data[$i]);
                    } else {
                        $row[$column['dt']] = $column['formatter']($data[$i][$column['db']], $data[$i]);
                    }
                } else {
                    if (!empty($column['db'])) {
                        $row[$column['dt']] = $data[$i][$columns[$j]['db']];
                    } else {
                        $row[$column['dt']] = "";
                    }
                }
            }

            $out[] = $row;
        }

        return $out;
    }

    /**
     * Database connection
     *
     * Obtain a MySQLi connection from a connection details array
     *
     * @param  array $conn SQL connection details. The array should have
     *    the following properties
     *     * host - host name
     *     * db   - database name
     *     * user - user name
     *     * pass - user password
     *  @return mysqli MySQLi connection
     */
    static function db($conn) {
        if (is_array($conn)) {
            return self::sql_connect($conn);
        }

        return $conn;
    }

    /**
     * Paging
     *
     * Construct the LIMIT clause for server-side processing SQL query
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array $columns Column information array
     * @return string SQL limit clause
     */
    static function limit($request, $columns) {
        $limit = '';

        if (isset($request['start']) && $request['length'] != -1) {
            $limit = "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        }

        return $limit;
    }

    /**
     * Ordering
     *
     * Construct the ORDER BY clause for server-side processing SQL query
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array $columns Column information array
     * @return string SQL order by clause
     */
    static function order($request, $columns) {
        $order = '';

        if (isset($request['order']) && count($request['order'])) {
            $orderBy = array();
            $dtColumns = self::pluck($columns, 'dt');

            for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
                $columnIdx = $request['order'][$i]['column'];
                $requestColumn = $request['columns'][$columnIdx];
                $column = $columns[$columnIdx];

                if ($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ? 'ASC' : 'DESC';
                    $orderBy[] = '`' . $column['db'] . '` ' . $dir;
                }
            }

            if (count($orderBy)) {
                $order = 'ORDER BY ' . implode(', ', $orderBy);
            }
        }

        return $order;
    }

    /**
     * Searching / Filtering
     *
     * Construct the WHERE clause for server-side processing SQL query.
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array $columns Column information array
     *  @return string SQL where clause
     */
    static function filter($request, $columns) {
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns = self::pluck($columns, 'dt');

        if (isset($request['search']) && $request['search']['value'] != '') {
            $str = $request['search']['value'];

            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                if ($requestColumn['searchable'] == 'true') {
                    if (!empty($column['db'])) {
                        $globalSearch[] = "`" . $column['db'] . "` LIKE '%" . self::escape($str) . "%'";
                    }
                }
            }
        }

        // Individual column filtering
        if (isset($request['columns'])) {
            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                $str = $requestColumn['search']['value'];

                if ($requestColumn['searchable'] == 'true' && $str != '') {
                    if (!empty($column['db'])) {
                        $columnSearch[] = "`" . $column['db'] . "` LIKE '%" . self::escape($str) . "%'";
                    }
                }
            }
        }

        // Combine the filters into a single string
        $where = '';

        if (count($globalSearch)) {
            $where = '(' . implode(' OR ', $globalSearch) . ')';
        }

        if (count($columnSearch)) {
            $where = $where === '' ? implode(' AND ', $columnSearch) : $where . ' AND ' . implode(' AND ', $columnSearch);
        }

        if ($where !== '') {
            $where = 'WHERE ' . $where;
        }

        return $where;
    }

    /**
     * Perform the SQL queries needed for an server-side processing requested,
     * utilising the helper functions of this class, limit(), order() and
     * filter() among others. The returned array is ready to be encoded as JSON
     * in response to an SSP request, or can be modified if needed before
     * sending back to the client.
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array $conn MySQLi connection resource or connection parameters array
     * @param  string $table SQL table to query
     * @param  string $primaryKey Primary key of the table
     * @param  array $columns Column information array
     * @return array          Server-side processing response array
     */
    static function simple($request, $conn, $table, $primaryKey, $columns) {
        $db = self::db($conn);

        // Build the SQL query string from the request
        $limit = self::limit($request, $columns);
        $order = self::order($request, $columns);
        $where = self::filter($request, $columns);

        // Main query to actually get the data
        $data = self::sql_exec($db,
            "SELECT `" . implode("`, `", self::pluck($columns, 'db')) . "`
             FROM `$table`
             $where
             $order
             $limit"
        );

        // Data set length after filtering
        $resFilterLength = self::sql_exec($db,
            "SELECT COUNT(`$primaryKey`)
             FROM `$table`
             $where"
        );
        $recordsFiltered = $resFilterLength[0][0];

        // Total data set length
        $resTotalLength = self::sql_exec($db,
            "SELECT COUNT(`$primaryKey`)
             FROM `$table`"
        );
        $recordsTotal = $resTotalLength[0][0];

        /*
         * Output
         */
        return array(
            "draw"            => isset($request['draw']) ? intval($request['draw']) : 0,
            "recordsTotal"    => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data"            => self::data_output($columns, $data)
        );
    }

    /**
     * Connect to the database
     *
     * @param  array $sql_details SQL server connection details array, with the
     *   properties:
     *     * host - host name
     *     * db   - database name
     *     * user - user name
     *     * pass - user password
     * @return mysqli Database connection handle
     */
    static function sql_connect($sql_details) {
        $db = new mysqli($sql_details['host'], $sql_details['user'], $sql_details['pass'], $sql_details['db']);

        if ($db->connect_error) {
            self::fatal("An error occurred while connecting to the database. Please check your connection details.");
        }

        return $db;
    }

    /**
     * Execute an SQL query on the database
     *
     * @param  mysqli $db  Database handler
     * @param  array  $bindings Array of PDO binding values from bind()
     * @param  string $sql SQL query to execute.
     * @return array        Result from the query (all rows)
     */
    static function sql_exec($db, $sql) {
        $result = $db->query($sql);

        if (!$result) {
            self::fatal("An error occurred while executing the SQL query: " . $db->error);
        }

        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * Throw a fatal error.
     *
     * This writes out an error message in a JSON string which DataTables will
     * see and show to the user in the browser.
     *
     * @param  string $msg Message to send to the client
     */
    static function fatal($msg) {
        echo json_encode(array(
            "error" => $msg
        ));

        exit(0);
    }

    /**
     * Escape unsafe characters for SQL query.
     *
     * @param  string $str String to be escaped
     * @return string Escaped string
     */
    static function escape($str) {
        return addslashes($str);
    }

    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning an array of the property values from each item.
     *
     *  @param  array  $a    Array to get data from
     *  @param  string $prop Property to read
     *  @return array        Array of property values
     */
    static function pluck($a, $prop) {
        $out = array();

        for ($i = 0, $len = count($a); $i < $len; $i++) {
            if (!empty($a[$i][$prop])) {
                $out[] = $a[$i][$prop];
            }
        }

        return $out;
    }
}
?>
