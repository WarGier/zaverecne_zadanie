<?php

Class PendulumController{

    private $request;
    private $result;
    private $conn;
    private $r;
    private $lastPos;
    private $lastAngle;

    /**
     * BallController constructor.
     * @param $request
     * @param $result
     * @param $conn
     * @param $r
     * @param $lastPos
     * @param $lastAngle
     */
    public function __construct($request, $result, $conn, $r,$lastPos,$lastAngle)
    {
        $this->request = $request;
        $this->result = $result;
        $this->conn = $conn;
        $this->r = $r;
        $this->lastPos = $lastPos;
        $this->lastAngle = $lastAngle;
    }

    function controller(){
        switch ($this->getRequest()){
            case "GET":
                $command = "octave --no-gui --silent  kyvadlo.m $this->r $this->lastPos $this->lastAngle";
                $output = shell_exec($command);
                $output = trim($output);
                $outputByLine = explode(PHP_EOL, $output);

                $outputArray=array();
                foreach ($outputByLine as $result){
                    $result = trim($result);
                    $result = preg_replace('/\s{1,}/', ' ',  $result);
                    $value = explode(" ", $result);
                    $outputArray[] = array(
                        "position" => $value[0],
                        "angle" => $value[1]
                    );

                }
                return $outputArray;
                break;
            case "PUT":
                $sql = "UPDATE statistika SET count = count + 1 WHERE name= 'pendulum'";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
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

    /**
     * @return mixed
     */
    public function getLastPos()
    {
        return $this->lastPos;
    }

    /**
     * @param mixed $lastPos
     */
    public function setLastPos($lastPos)
    {
        $this->lastPos = $lastPos;
    }

    /**
     * @return mixed
     */
    public function getLastAngle()
    {
        return $this->lastAngle;
    }

    /**
     * @param mixed $lastAngle
     */
    public function setLastAngle($lastAngle)
    {
        $this->lastAngle = $lastAngle;
    }

}
?>