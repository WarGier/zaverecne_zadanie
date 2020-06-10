<?php

Class DampingController{
    private $request;
    private $result;
    private $conn;
    private $r;
    private $lastPos;


    /**
     * DampingController constructor.
     * @param $request
     * @param $result
     * @param $conn
     * @param $r
     * @param $lastPos
     */
    public function __construct($request, $result, $conn, $r, $lastPos)
    {
        $this->request = $request;
        $this->result = $result;
        $this->conn = $conn;
        $this->r = $r;
        $this->lastPos = $lastPos;
    }

    function controller(){
        switch ($this->getRequest()){
            case "GET":
                $command = "octave --no-gui --silent  car.m $this->r $this->lastPos";
                $output = shell_exec($command);
                $output = trim($output);
                $outputByLine = explode(PHP_EOL, $output);

                $outputArray=array();
                foreach ($outputByLine as $result){
                    $result = trim($result);
                    $result = preg_replace('/\s{1,}/', ' ',  $result);
                    $value = explode(" ", $result);
                    $outputArray[] = array(
                        "carPos" => $value[0],
                        "wheelPos" => $value[1]
                    );
                }
                return $outputArray;
                break;
            case "POST":
                $sql = "INSERT INTO ball";
                break;
            case "PUT":
                $sql = "UPDATE ball SET";
                break;
            case "DELETE":
                $sql = "DELETE FROM ball";
                break;

        }
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * @param mixed $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @return mixed
     */
    public function getR()
    {
        return $this->r;
    }

    /**
     * @param mixed $r
     */
    public function setR($r)
    {
        $this->r = $r;
    }


}
?>