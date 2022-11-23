<?php

/**
 * This file is part of Berevi Collection applications.
 *
 * (c) Alan Da Silva
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or on Codecanyon
 *
 * @see https://codecanyon.net/licenses/terms/regular
 */

namespace app\library;

class DataEngine extends \ArrayIterator implements XMLEngine
{
    const XML_VERSION = "1.0";
    const DATABASE_VERSION = "1.0";
    const ENCODING = "UTF-8";
    const ROOT_NAME = "database";

    private $position = 0;
    private $array = [];

    /**
     * Returns the current element of the array.
     *
     * @return string
     */
    public function current()
    {
        return $this->array[$this->position];
    }

    /**
     * Returns the current key.
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Moves the cursor to the next item.
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Resets the cursor position to 0.
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Moves the internal cursor.
     *
     * @param $position int
     */
    public function seek($position)
    {
        $anciennePosition = $this->position;
        $this->position = $position;

        if (!$this->valid()) {
            trigger_error('The specified position is invalid', E_USER_WARNING);
            $this->position = $anciennePosition;
        }
    }

    /**
     * Used to test whether the current position is valid.
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->array[$this->position]);
    }

    /**
     * Checks if the key exists.
     *
     * @param $key int
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return isset($this->array[$key]);
    }

    /**
     * Returns the value of the requested key.
     * A notice will be issued if the key does not exist, as for the real tables.
     *
     * @param $key int
     *
     * @return string
     */
    public function offsetGet($key)
    {
        return $this->array[$key];
    }

    /**
     * Assigns a value to an entry.
     *
     * @param $key int
     * @param $value string
     */
    public function offsetSet($key, $value)
    {
        $this->array[$key] = $value;
    }

    /**
     * Deletes an entry and will issue an error if it does not exist, as for true arrays.
     *
     * @param $key int
     */
    public function offsetUnset($key)
    {
        unset($this->array[$key]);
    }

    /**
     * Returns the number of entries in the table.
     *
     * @return int
     */
    public function count()
    {
        return count($this->array);
    }

    /**
     * Checks whether a file exists.
     *
     * @param $filename string
     */
    private function fileExists($filename)
    {
        if (!file_exists(__DIR__."/../config/data/".$filename.".xml")) {
            throw new \InvalidArgumentException("The database ".$filename." does not exist.");
        }
    }

    /**
     * Return full file name with it's extension if well formatted.
     *
     * @param $filename string|null
     *
     * @return string
     */
    public function getDatabase($filename = "")
    {
        if ($filename == "") {
            throw new \InvalidArgumentException("The Data Engine requires a correct file name.");
        }

        $ext = explode(".", $filename);
        if (!empty($ext[1])) {
            throw new \InvalidArgumentException("Invalid file format for ".$filename);
        }

        return $filename."xml";
    }

    /**
     * Writing XML from scratch (using XMLWriter).
     * Creating the database with columns and n entries.
     *
     * @param $filename string
     * @param $id int
     */
    public function createDatabase($filename, $tablename, $columns = [], $local = false, $module = null, $mode = "prod")
    {
        $this->getDatabase($filename);
        if (empty($tablename) || empty($columns)) {
            throw new \InvalidArgumentException("Table name and/or columns are missing.");
        }

        $filePath = ($local && $module) ?
            getcwd()."/../src/".$module."/Resources/config/data/".$filename.".xml" :
            __DIR__."/../config/data/".$filename.".xml"
        ;

        $xml = new \XMLWriter();
        $mode == "prod" ? $xml->openURI($filePath) : $xml->openMemory();
        $xml->setIndent(true);
        $xml->startDocument(self::XML_VERSION, self::ENCODING);
        $xml->startElement(self::ROOT_NAME);
        $xml->writeAttribute("name", $filename);
        $xml->writeAttribute("version", self::DATABASE_VERSION);
        $xml->startElement("datatable");
        $xml->writeAttribute("name", $tablename);
        $this->array = $columns;
        $this->position = 1;
        foreach ($columns as $key => $value) {
            $position = array_keys($value);
            $xml->startElement("row");
            $xml->writeAttribute("id", $this->key());
            for ($i = 0; $i < count($position); $i++) {
                $xml->writeElement($position[$i], $value[$position[$i]]);
            }

            $xml->endElement();
            $this->next();
        }

        $xml->endElement();
        $xml->endElement();
        if ($mode == "prod") {
            $xml->flush();
        }

        if (!$local && !$module) {
            echo $mode == "prod" ?
                "Database ".$filename." created with success." :
                '<pre class="sh_xml">'.htmlspecialchars($xml->outputMemory(), ENT_QUOTES, 'UTF-8').'</pre>'
            ;
        }
    }

    /**
     * Reading / Getting data from an XML (using XMLReader and SimpleXMLElement)
     *
     * @param $filename string
     * @param $id int
     */
    public function readData($filename, $id)
    {
        $this->fileExists($filename);
        $filePath = file_get_contents(__DIR__."/../config/data/".$filename.".xml");
        $reader = new \XMLReader();
        $reader->xml($filePath);
        while ($reader->read() && $reader->name !== 'row');

        $data = "";
        while ($reader->name === 'row') {
            if ($reader->getAttribute("id") == $id) {
                $node = new \SimpleXMLElement($reader->readOuterXML());
                $data = $node;
                break;
            }

            $reader->next('row');
        }

        return $data ? $data : null;
    }

    /**
     * Getting the last node from an XML file.
     *
     * @param $filename string
     * @return array
     */
    public function readLast($filename, $local = false, $module = null)
    {
        if ($local && $module) {
            $filePath = file_get_contents(getcwd()."/../src/".$module."/Resources/config/data/".$filename.".xml");
        } else {
            $this->fileExists($filename);
            $filePath = file_get_contents(__DIR__."/../config/data/".$filename.".xml");
        }

        $load = new \SimpleXMLElement($filePath);
        $lastRow = $load->xpath('/database/datatable/row[last()][@id]');
        $data = $lastRow[0];

        return $data;
    }

    /**
     * Adding child to an already existing XML (using SimpleXMLElement)
     *
     * @param $filename string
     * @param $array array()
     */
    public function addData($filename, $columns = [], $local = false, $module = null)
    {
        $this->getDatabase($filename);
        if (empty($columns)) {
            throw new \InvalidArgumentException("Columns are missing.");
        }

        if ($local && $module) {
            $filePath = file_get_contents(getcwd()."/../src/".$module."/Resources/config/data/".$filename.".xml");
        } else {
            $this->fileExists($filename);
            $filePath = file_get_contents(__DIR__."/../config/data/".$filename.".xml");
        }

        $load = new \SimpleXMLElement($filePath);
        $lastRow = $load->xpath('/database/datatable/row[last()][@id]');
        if (empty($lastRow)) {
            throw new \InvalidArgumentException("The columns are invalid.");
        }

        $id = $lastRow[0]->attributes()->id + 1;
        $newchild = $load->datatable->addChild("row");
        $newchild->addAttribute("id", $id);
        if (empty(array_filter($columns[0]))) {
            throw new \InvalidArgumentException("Element is required.");
        }

        $this->array = $columns;
        $this->position = 1;
        foreach ($columns as $key => $value) {
            $position = array_keys($value);
            for ($i = 0; $i < count($position); $i++) {
                $newchild->addChild($position[$i], $value[$position[$i]]);
            }

            $this->next();
        }

        $dom = new \DOMDocument(self::XML_VERSION, self::ENCODING);
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($load->asXML(), LIBXML_PARSEHUGE);
        $dom->formatOutput = true;
        ($local && $module) ?
            $dom->save(getcwd()."/../src/".$module."/Resources/config/data/".$filename.".xml") :
            $dom->save(__DIR__."/../config/data/".$filename.".xml")
        ;
    }

    /**
     * Modifying a node in an existing XML (using DomDocument and DOMXPath)
     *
     * @param $filename string
     * @param $id int
     * @param $array array()
     */
    public function updateData($filename, $id, $columns = [], $local = false, $module = null)
    {
        if ($local && $module) {
            $filePath = file_get_contents(getcwd()."/../src/".$module."/Resources/config/data/".$filename.".xml");
        } else {
            $this->fileExists($filename);
            $filePath = file_get_contents(__DIR__."/../config/data/".$filename.".xml");
        }

        $parent = new \DOMDocument(self::XML_VERSION, self::ENCODING);
        $parent_node = $parent->createElement('row');
        $attribute = $parent->createAttribute("id");
        $attribute->value = $id;
        $parent_node->appendChild($attribute);
        $this->array = $columns;
        $this->position = 1;
        foreach ($columns as $key => $value) {
            $position = array_keys($value);
            for ($i = 0; $i < count($position); $i++) {
                $parent_node->appendChild($parent->createElement($position[$i], $value[$position[$i]]));
            }

            $this->next();
        }

        $parent->appendChild($parent_node);

        $dom = new \DOMDocument(self::XML_VERSION, self::ENCODING);
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($filePath, LIBXML_PARSEHUGE);
        $dom->formatOutput = true;

        $xpath = new \DOMXpath($dom);
        $nodelist = $xpath->query("/database/datatable/row[@id={$id}]");
        $oldnode = $nodelist->item(0);

        $newnode = $dom->importNode($parent->documentElement, true);
        if (empty($oldnode)) {
            throw new \InvalidArgumentException("The id is invalid.");
        }

        $oldnode->parentNode->replaceChild($newnode, $oldnode);
        ($local && $module) ?
            $dom->save(getcwd()."/../src/".$module."/Resources/config/data/".$filename.".xml") :
            $dom->save(__DIR__."/../config/data/".$filename.".xml")
        ;
    }

    /**
     * Deleting a node in an existing XML (using DomDocument and DOMXPath)
     *
     * @param $filename string
     * @param $id int
     */
    public function deleteData($filename, $id)
    {
        $this->fileExists($filename);
        $filePath = file_get_contents(__DIR__."/../config/data/".$filename.".xml");

        $dom = new \DOMDocument(self::XML_VERSION, self::ENCODING);
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($filePath, LIBXML_PARSEHUGE);
        $dom->formatOutput = true;

        $xpath = new \DOMXpath($dom);
        $nodelist = $xpath->query("/database/datatable/row[@id={$id}]");
        $oldnode = $nodelist->item(0);
        if (empty($oldnode)) {
            throw new \InvalidArgumentException("The id is invalid.");
        }

        $oldnode->parentNode->removeChild($oldnode);
        $dom->save(__DIR__."/../config/data/".$filename.".xml");
    }
}
