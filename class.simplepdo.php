<?php
/*
Copyright (c) 2012, Philipp Kiszka
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

    Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
    Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/
class simplepdo {
    private $dbstring;
    private $thedb;

    /**
     * Constructor
     *
     * @access protected
     */
    function __construct($str)
    {
        $this->dbstring = $str;
        $this->thedb = new PDO($this->dbstring);
    }

    private function getRows($rows)
    {
        $values = array();
        if (!empty($rows)) {
            foreach ($rows as $row) {
                array_push($values, $row);
            }
        }
        return $values;
    }

    function query($query)
    {
        $stmt = $this->thedb->query($query);
        return $this->getRows($stmt);
    }

    function execute($query)
    {
        return $this->thedb->exec($query);
    }

    function executePrepared($query, array $values)
    {
        $prep = $this->thedb->prepare($query);

        return $prep->execute($values);
    }

    function queryPrepared($query, array $values)
    {
        $prep = $this->thedb->prepare($query);
        $prep->execute($values);
        return $this->getRows($prep->fetchAll(PDO::FETCH_ASSOC));
    }

    function lastId(){
    	return $this->thedb->lastInsertId();
    }
}

?>