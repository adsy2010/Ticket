<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 08/11/2016
 * Time: 14:33
 */

/*function render($template, $data = array())
{
    if(!is_array($data)) return null;

    foreach($data as $key=>$val)
        $template = str_replace("{{$key}}", $val, $template);

    return $template;
}*/

class databaseClass
{
    private $db;
    function __construct () {
        $this->db = new PDO(
            'mysql:host=localhost;dbname=test',
            'admin',
            'root'
        );
    }

    /**
     * @param string $query
     * @param array $argArray
     * @return array|null
     * @throws Exception
     */
    public function runQuery($query = '', $argArray = array()) {
        $stmt = null;
        try
        {
            if(!$stmt = $this->db->prepare($query)) throw new Exception("Prepared query failed.");

            if (sizeof($argArray) > 0) $stmt->execute($argArray);
            else $stmt->execute();

        }
        catch(PDOException $ex)
        {
            echo "An Error occured!: ".$ex->getMessage();
        }

        return ($stmt == null) ? null : $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

/*
try{
    $dbObj = new databaseClass();
}
catch (Exception $e)
{
    echo $e->getMessage();
}*/

