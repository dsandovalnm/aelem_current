<?php

	require('../../PHPspreadsheet/vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

	include_once('../../controllers/Payment.php');
	include_once('../../controllers/Seminarios.php');
	include_once('../../controllers/Cursos_Seminarios.php');
	include_once('../../controllers/Suscripciones.php');
	include_once('../../controllers/Usuarios.php');

	$filename = isset($_GET['export']) ? $_GET['export'].'.xlsx' : 'noname.xlsx';

	$excel = new Spreadsheet;
	$hojaActiva = $excel->getActiveSheet();

	$hojaActiva->setTitle("Excel Aelem");

	$hojaActiva->setCellValue('A1', 'NOMBRE');
	$hojaActiva->setCellValue('B1', 'APELLIDO');
	$hojaActiva->setCellValue('C1', 'TELEFONO');
	$hojaActiva->setCellValue('D1', 'PAIS');
	$hojaActiva->setCellValue('E1', 'EMAIL');
	$hojaActiva->setCellValue('F1', 'FECHA');
	$hojaActiva->setCellValue('G1', 'SUSCRIPCION');
	$hojaActiva->setCellValue('H1', 'MONTO');
	$hojaActiva->setCellValue('I1', 'ESTADO');

	$row = 2;

	$pay = new Payment;
	$sem = new Seminario;
	$cur_sem = new CursoSeminario;
	$sus = new Suscripcion;
	$usu = new User;

	$results = [];
	$payments = [];
	
	if(isset($_GET['payments'])) {
		switch($_GET['payments']) {
			case 'all' :
				$payments = $pay->getPayments();

				foreach($payments as $payment) {
					
					$details = $pay->getDetailsByTransaction($payment['transaction_key']);
					$user = $usu->getByEmail($payment['email']);
					$subscription = $cur_sem->getByCode($details['course_code']);

					$arrayPayment = [
						'info' => $payment,
						'details' => $details,
						'user' => $user,
						'subscription' => $subscription
					];

					array_push($results, $arrayPayment);
				}
			break;

			case 'set' :
				$email = (isset($_POST['email-pago-buscar']) && $_POST['email-pago-buscar'] !== '') ? $_POST['email-pago-buscar'] : '';
				$seminarioCode = (isset($_POST['seminario-pago-buscar']) && $_POST['seminario-pago-buscar'] !== '') ? $_POST['seminario-pago-buscar'] : '';
				
				if($email !== '' && $seminarioCode === '') {
					$payments = $pay->getPaymentsByEmail($email);

					foreach($payments as $payment) {

						$details = $pay->getDetailsByTransaction($payment['transaction_key']);
						$user = $usu->getByEmail($email);
						$subscription = $cur_sem->getByCode($details['course_code']);

						$arrayPayment = [
							'info' => $payment,
							'details' => $details,
							'user' => $user,
							'subscription' => $subscription
						];

						array_push($results, $arrayPayment);
					}
					
				}else if($email === '' && $seminarioCode !== '') {
					$paymentDetails = $pay->getPaymentDetailsBySeminario($seminarioCode);

					foreach($paymentDetails as $details) {

						$payment = $pay->getByTransaction($details['transaction_key']);
						$user = $usu->getByEmail($payment['email']);
						$subscription = $cur_sem->getByCode($details['course_code']);

						$arrayPayment = [
							'info' => $payment,
							'details' => $details,
							'user' => $user,
							'subscription' => $subscription
						];

						array_push($results, $arrayPayment);
					}
				}
			break;
		}
	}

	foreach($results as $result) {
		$hojaActiva->setCellValue("A$row", $result['user']['nombre']);
		$hojaActiva->setCellValue("B$row", $result['user']['apellido']);
		$hojaActiva->setCellValue("C$row", $result['user']['telefono']);
		$hojaActiva->setCellValue("D$row", $result['user']['pais']);
		$hojaActiva->setCellValue("E$row", $result['user']['email']);
		$hojaActiva->setCellValue("F$row", $result['info']['date']);
		$hojaActiva->setCellValue("G$row", $result['subscription']['nombre']);
		$hojaActiva->setCellValue("H$row", $result['info']['total']);
		$hojaActiva->setCellValue("I$row", $result['info']['status']);

		$row++;
	}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Cache-Control: max-age=0');

		$writer = IOFactory::createWriter($excel, 'Xlsx');
		$writer->save('php://output');
		exit;
?>