<?php
	require_once '../Negocio/productos/nProducto.php';

	if (!empty($_FILES['file'])) {
		$uploadDir = 'files/productos/';
		$response = [];

		if (!is_dir($uploadDir)) {
			mkdir($uploadDir, 0777, true);
		}

		$file = $_FILES['file'];
		$id = $_POST['id'];
		$extension_imagen = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		$filename = 'img_procudto_' . $id . '.' . $extension_imagen;
		$uploadFile = $uploadDir . $filename;
		
		if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
			$producto = new nProducto($id, '', '', '', 0, 0, $filename);
			$producto->actualizar_imagen();
			$response['status'] = 'success';
		} else {
			$response['status'] = 'error';
			$response['message'] = 'File upload failed.';
		}
	} else {
		$response['status'] = 'error';
		$response['message'] = 'No file uploaded.';
	}

	echo json_encode($response);
	exit();
?>