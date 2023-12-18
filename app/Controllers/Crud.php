<?php

namespace App\Controllers;

use App\Models\CrudModel;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Dompdf\Dompdf;

class Crud extends BaseController
{
	function index()
	{	
		$crudModel = new CrudModel();

        $data['user_data'] = $crudModel->orderBy('id', 'DESC')->paginate(10);

        $data['pagination_link'] = $crudModel->pager;

        return view('crud_view', $data);
	}

	function add()
	{
		return view('add_data');
	}

	function add_validation()
	{
		helper(['form', 'url']);
        
        $error = $this->validate([
            'first_name' 	=> 'required',
            'last_name' 	=> 'required',
            'email' 		=> 'required|valid_email',
            'address'		=> 'required',
            'dob'			=> 'required',
            //'profile_pic'	=> 'required',
            'gender'		=> 'required'
        ]);        

        if(!$error)
        {
        	echo view('add_data', [
                'error' => $this->validator
            ]);
        } 
        else 
        {
            $crudModel = new CrudModel();
			$profile_pic = $this->request->getFile('profile_pic');
			if($profile_pic->isValid()){
				//$profile_pic->store();
				$profile_pic->move(ROOTPATH.'public/uploads');
				//$file->move(WRITEPATH.'public/uploads');
				$file = $profile_pic->getName();
			}
			else{
				$file='';
			}
            
            $crudModel->save([
                'first_name'   => $this->request->getVar('first_name'),
                'last_name'    => $this->request->getVar('last_name'),                
                'email'  	   => $this->request->getVar('email'),
                'address'  	   => $this->request->getVar('address'),
                'dob'  		   => date('Y-m-d',strtotime($this->request->getVar('dob'))),
                'gender'  	   => $this->request->getVar('gender'),
                'created_at'   => date('Y-m-d H:i:s'),
                'profile_pic'  => $file,
            ]);          
            
            $session = \Config\Services::session();

            $session->setFlashdata('success', 'User Data Added');

            return $this->response->redirect(site_url('/crud'));
        }

	}

	// show single user
    function fetch_single_data($id = null)
    { 
        $crudModel = new CrudModel();

        $data['user_data'] = $crudModel->where('id', $id)->first();

        return view('edit_data', $data);
    }

    function edit_validation()
    {
    	helper(['form', 'url']);
        
        $error = $this->validate([
            'first_name' 	=> 'required',
            'last_name' 	=> 'required',
            'email' 		=> 'required|valid_email',
            'address'		=> 'required',
            'dob'			=> 'required',
            //'profile_pic'	=> 'required',
            'gender'		=> 'required'
        ]);

        $crudModel = new CrudModel();

        $id = $this->request->getVar('id');

        if(!$error)
        {
        	$data['user_data'] = $crudModel->where('id', $id)->first();
        	$data['error'] = $this->validator;
        	echo view('edit_data', $data);
        } 
        else 
        {
	        $profile_pic = $this->request->getFile('profile_pic');
			if($profile_pic->isValid()){
				//$profile_pic->store();
				$profile_pic->move(ROOTPATH.'public/uploads');
				$file = $profile_pic->getName();
			}
			else{
				$file=$this->request->getVar('old_profile_pic');
			}
			$data = [
                'first_name'   	=> $this->request->getVar('first_name'),
                'last_name'   	=> $this->request->getVar('last_name'),                
                'email'  		=> $this->request->getVar('email'),
                'address'  		=> $this->request->getVar('address'),
                'dob'  			=> date('Y-m-d',strtotime($this->request->getVar('dob'))),
                'gender'  		=> $this->request->getVar('gender'),
                'updated_at'  	=> date('Y-m-d H:i:s'),
                'profile_pic'  	=> $file,
            ]; 
			//if(!empty($file))$data['profile_pic']=$file;			
			//echo '<pre>';print_r($data);die;			

        	$crudModel->update($id, $data); 

        	$session = \Config\Services::session();

            $session->setFlashdata('success', 'User Data Updated');

        	return $this->response->redirect(site_url('/crud'));
        }
    }

    function delete($id)
    {
        $crudModel = new CrudModel();

        $crudModel->where('id', $id)->delete($id);

        $session = \Config\Services::session();

        $session->setFlashdata('success', 'User Data Deleted');

        return $this->response->redirect(site_url('/crud'));
    }
	function export()
	{
		$crudModel = new CrudModel();

		$data = $crudModel->findAll();

		$file_name = 'users_list.xlsx';

		$spreadsheet = new Spreadsheet();

		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'S.No');
		$sheet->setCellValue('B1', 'Name');
		$sheet->setCellValue('C1', 'Email');
		$sheet->setCellValue('D1', 'Dob');
		$sheet->setCellValue('E1', 'Gender');
		$sheet->setCellValue('F1', 'Address');

		$count = 2;
		
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(40);
		$sheet->getColumnDimension('C')->setWidth(35);
		$sheet->getColumnDimension('D')->setWidth(15);
		$sheet->getColumnDimension('E')->setWidth(15);
		$sheet->getColumnDimension('F')->setWidth(25);
		//$sheet->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
		$i=1;

		foreach($data as $row)
		{
			$sheet->setCellValue('A' . $count, $i);
			$sheet->setCellValue('B' . $count, trim($row['first_name'].' '.$row['last_name']));
			$sheet->setCellValue('C' . $count, $row['email']);
			$sheet->setCellValue('D' . $count, trim(date('d-m-Y',strtotime($row['dob']))));
			$sheet->setCellValue('E' . $count, $row['gender']);
			$sheet->setCellValue('F' . $count, $row['address']);

			$count++;
			$i++;
		}

		$writer = new Xlsx($spreadsheet);

		$writer->save($file_name);

		header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');

		header('Expires: 0');

		header('Cache-Control: must-revalidate');

		header('Pragma: public');

		header('Content-Length:' . filesize($file_name));

		flush();

		readfile($file_name);

		exit;
	}
	
	function download_pdf(){
		$crudModel = new CrudModel();

		$data['user_data'] = $crudModel->orderBy('id','desc')->findAll();

		$dompdf = new Dompdf();
         
        $html = view('pdf_content', $data);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream('pdf_content.pdf', [ 'Attachment' => false ]);
		
	}
	
}

?>