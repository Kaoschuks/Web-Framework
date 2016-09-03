<?php

/**
 * Functionality short summary.
 *
 * Functionality description.
 *
 * @version 1.0
 * @author Kaos
 */
if(is_file("Business Layer/Controls/IControl.php"))
{
    require_once "Business Layer/Controls/IControl.php";
}

class File implements IControl
{        
    public function Get_Control($control = null, $data = null)
    {
        switch($control)
        {
            case "create_file":
            {
                return $this->Create_File($this->format($data));
                break;
            }
            case "update_file":
            {
                return $this->Update_File($this->format($data));
                break;
            }
            case "delete_file":
            {
                return $this->Delete_File($this->format($data));
                break;
            }
            case "read_file":
            {
                return $this->Read_File($this->format($data));
                break;
            }
            default:
            {
                return "Wrong file functionality type {$control} sent";    
            }
        }
    }
    
    private function format($data)
    {
        unset($data['type']);
        unset($data['provider']);
        return $data;
    }
    
    private function Create_File($data)
    {
        $DMining = new DMining();
        return $DMining->Process_Data($data, "create_file");
        unset($DMining);
    }
    
    private function Read_File($data)
    {
        $DMining = new DMining();
        return $DMining->Process_Data($data, "read_file");
        unset($DMining);
    }
    
    private function Update_File($data)
    {
        $DMining = new DMining();
        return $DMining->Process_Data($data, "update_file");
        unset($DMining);
    }
    
    private function Delete_File($data)
    {
        $DMining = new DMining();
        return $DMining->Process_Data($data, "delete_file");
        unset($DMining);
    }
}
