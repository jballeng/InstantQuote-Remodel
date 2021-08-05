<?php
class InstantquoteUploadModuleFrontController extends ModuleFrontController{
    
    public function initContent(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
           
            $upload_dir = _PS_ROOT_DIR_.'/upload/requestquote/';
            if(defined("ANTIVIRUS_EXEC_PATH")){
                $output = "";
                $return = "";                
                exec(ANTIVIRUS_EXEC_PATH." ".$_FILES["files"]["tmp_name"][0]." > /dev/null ", $output, $return); 
                /* stastus codes&
                      0    no threat found
                      1    threat found and cleaned
                      10   some files could not be scanned (may be threats)
                      50   threat found
                      100  error &
                */
                      switch ($return) {
                          case 1:
                          case 10:
                          case 50:
                                     echo json_encode(array("hasError" => 1, "virusDetected" => 1, "file" => $_FILES["files"]["name"][0]));
                                     exit();
                                     break;
                            case 0:
                            case 100:
                                        $upload_handler =$this->processUpload();
                                        exit;
                                        break;
                            default:
                                        echo json_encode(array("hasError" => 1, "virusDetected" => 1, "file" => $_FILES["files"]["name"][0]));
                                        exit();
                                        break;
                      }
                         
            }
        }else {
            Tools::redirect('index.php');
        }
        $this->processUpload();
        die;
    }
    public function processUpload(){
       $upload_dir = _PS_UPLOAD_DIR_.'requestquote/';
        if(!file_exists($upload_dir)||!is_dir($upload_dir)){
            mkdir($upload_dir);
            chmod(_PS_UPLOAD_DIR_.'colorfulbanner',0755);
        }
        $path_parts = pathinfo($_FILES["files"]["name"]);
        $extension = $path_parts['extension'];
        $uniquName=uniqid('rfq_');
        $fileName=$uniquName.'.'.$extension;
        if(@move_uploaded_file($_FILES['files']['tmp_name'],$upload_dir.$fileName))
        {
            $output = [[
                'url'  => _PS_BASE_URL_SSL_.'upload/requestquote/'.$fileName,
                'thumbnail_url' => _PS_BASE_URL_SSL_.'upload/requestquote/'.$fileName,
                'name' => $fileName,
                'real_name'=>$_FILES['files']['name'],
                'type' => $extension,
                'size' => $_FILES['files']['size'],
                'delete_url'   => "",
                'delete_type' => 'GET' // method for destroy action
            ]];
            $response["files"] = $output;
            $response["hasError"] =0;
            echo json_encode($response);die;
        } 
        echo json_encode(array("hasError" => 1, "errorUpload" => 1,'message'=>"Unable to upload file please try again","file" => $_FILES["files"]["name"]));die;
    }
    public function _validate(){
        $extension = array('.txt', '.rtf', '.doc', '.docx', '.pdf', '.zip', '.png', '.jpeg', '.gif', '.jpg', '.igs', '.dxf');
        $path_parts = pathinfo($_FILES["file"]["name"][0]);
        $extension = $path_parts['extension'];
        
    }
}
