<?php

/*
 * This file is part of the Plateforme étudiante USEC.
*
* (c) USEC <contact@usec-utc.fr>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace USEC\StudentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionAdminController extends Controller
{
	public function indexAction() {
		$em = $this->getDoctrine()->getManager();
		$students = $em->getRepository('USECStudentBundle:Student')->findAllSubscribed();
		return $this->render('USECStudentBundle:Subscription:list.html.twig', array(
				'students' => $students,
		));
	}
	
	public function showAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		$student = $em->getRepository('USECStudentBundle:Student')->findOneSubscribed($id);
		if(!$student)
			throw $this->createNotFoundException('L\'étudiant n\'existe pas ou n\'est plus accessible');
		return $this->render('USECStudentBundle:Subscription:show.html.twig', array(
				'student' => $student,
		));
	}
	
	public function exportCsvAction() {
		// create the writer
		$writer = $this->get('phpexcel')->createWriter($this->studentListToExcelObject(), 'CSV');
		// create the response
		$response = $this->get('phpexcel')->createStreamedResponse($writer);
		// adding headers
		$response->headers->set('Content-Type', 'application/csv; charset=utf-8');
		$response->headers->set('Content-Disposition', 'attachment;filename=liste-consultants.csv');
		$response->headers->set('Pragma', 'public');
		$response->headers->set('Cache-Control', 'maxage=1');
		
		return $response;
	}
	
	public function exportExcelAction() {
		// create the writer
		$writer = $this->get('phpexcel')->createWriter($this->studentListToExcelObject(), 'Excel5');
		// create the response
		$response = $this->get('phpexcel')->createStreamedResponse($writer);
		// adding headers
		$response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
		$response->headers->set('Content-Disposition', 'attachment;filename=liste-consultants.xls');
		$response->headers->set('Pragma', 'public');
		$response->headers->set('Cache-Control', 'maxage=1');
		
		return $response;
	}
	
	private function studentListToExcelObject() {
		$em = $this->getDoctrine()->getManager();
		$students = $em->getRepository('USECStudentBundle:Student')->findAllSubscribed();
		$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
		
		$phpExcelObject->getProperties()->setCreator("Usec")
		->setLastModifiedBy("Usec")
		->setTitle("Liste des consultants")
		->setSubject("Liste des consultants")
		->setDescription("Etudiants inscrits comme étudiants à l\'Usec.")
		->setKeywords("usec office etudiant consultant")
		->setCategory("Usec RH");
		// Set headers
		$phpExcelObject->setActiveSheetIndex(0)
		->setCellValue('A1', 'id')
		->setCellValue('B1', 'Email')
		->setCellValue('C1', 'Telephone')
		->setCellValue('D1', 'Prenom')
		->setCellValue('E1', 'Nom')
		->setCellValue('F1', 'Login UTC')
		->setCellValue('G1', 'Filiere')
		->setCellValue('H1', 'Semestre sortie')
		->setCellValue('I1', 'Apprenti')
		->setCellValue('J1', 'Competences')
		->setCellValue('K1', 'Interesse par')
		->setCellValue('L1', 'Motivation')
		->setCellValue('M1', 'Cv uploade ?')
		->setCellValue('N1', 'Inscrit le')
		->setCellValue('O1', 'Profil maj le');
		// Set values
		$i = 2;
		foreach($students as $student) {
			$phpExcelObject->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $student->getId())
			->setCellValue('B' . $i, $student->getEmail())
			->setCellValue('C' . $i, $student->getPhone())
			->setCellValue('D' . $i, $student->getFirstName())
			->setCellValue('E' . $i, $student->getName())
			->setCellValue('F' . $i, $student->getUsername())
			->setCellValue('G' . $i, $student->getCourse())
			->setCellValue('H' . $i, $student->getEndCourseSemester())
			->setCellValue('I' . $i, $student->getApprenti())
			->setCellValue('J' . $i, $student->getSkills())
			->setCellValue('K' . $i, $student->getInterestedIn())
			->setCellValue('L' . $i, $student->getMotivation())
			->setCellValue('M' . $i, $student->getIsCvUploaded())
			->setCellValue('N' . $i, $student->getCreationDate()->format("d/m/Y"))
			->setCellValue('O' . $i, $student->getChangeDate() != NULL ? $student->getChangeDate()->format("d/m/Y") : "Jamais modifié");
			$i++;
		}
		$phpExcelObject->getActiveSheet()->setTitle('Etudiants inscrits');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$phpExcelObject->setActiveSheetIndex(0);
		return $phpExcelObject;
	}
}