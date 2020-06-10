<?php

Class BallController{

    private $request;
    private $result;
    private $conn;
    private $r;
    private $rychlost;
    private $zrychlenie;

    /**
     * BallController constructor.
     * @param $request
     * @param $result
     * @param $conn
     * @param $r
     * @param $rychlost
     * @param $zrychlenie
     */
    public function __construct($request, $result, $conn, $r, $rychlost, $zrychlenie)
    {
        $this->request = $request;
        $this->result = $result;
        $this->conn = $conn;
        $this->r = $r;
        $this->rychlost = $rychlost;
        $this->zrychlenie = $zrychlenie;
    }

    function controller(){
        switch ($this->getRequest()){
            case "GET":

                $command = "octave --no-gui --silent  gulicka.m $this->r $this->rychlost $this->zrychlenie";
                $output = shell_exec($command);
                $output = trim($output);
                $outputByLine = explode(PHP_EOL, $output);

                $outputArray=array();
                foreach ($outputByLine as $result){
                    $result = trim($result);
                    $result = preg_replace('/\s{1,}/', ' ',  $result);
                    $value = explode(" ", $result);
                    $outputArray[] = array(
                        "speed" => $value[0],
                        "acceleration" => $value[1]
                    );
                }
                return $outputArray;
                break;

            case "PUT":
                $sql = "UPDATE statistika SET count = count + 1 WHERE name= 'ball'";
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




}

?>