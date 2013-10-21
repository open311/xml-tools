<?php
if ($_REQUEST['xml']) {

	$xml_string = $_REQUEST['xml'];
	$xml_string = trim($xml_string);
	
	// PHP XSLT Processing from http://www.tonymarston.net/php-mysql/xsl.html

	$xp = new XsltProcessor();

	// This obtains the XSL stylesheet from an external file and loads it into the XSLT resource. It will also load in any external templates specified with the <xsl:include> command.

	  // create a DOM document and load the XSL stylesheet
	  $xsl = new DomDocument;
	  $xsl->load('xml2json_spark.xsl');

	  // import the XSL styelsheet into the XSLT process
	  $xp->importStylesheet($xsl);

	// This obtains the XML data from an external file and loads it into a separate document instance.

	  // create a DOM document and load the XML data
	  $xml_doc = new DomDocument;

	//  Import an XML flat file
	//  $xml_doc->load('discovery.xml');

	// Import an XML document as a string
	$xml_doc->loadXML($xml_string);


	// This involves using the transformation method of the XSLT resource created ealier with a specified XML document:

	  // transform the XML into JSON using the XSL file
	  if ($json = $xp->transformToXML($xml_doc)) {
			$json = indent($json);
	  } else {
	      trigger_error('XSL transformation failed.', E_USER_ERROR);
	  } 

}





/**
 * Indents a flat JSON string to make it more human-readable. 
 * From http://recursive-design.com/blog/2008/03/11/format-json-with-php/
 * 
 * @param string $json The original JSON string to process.
 *
 * @return string Indented version of the original JSON string.
 */
function indent($json) {

    $result      = '';
    $pos         = 0;
    $strLen      = strlen($json);
    $indentStr   = '  ';
    $newLine     = "\n";
    $prevChar    = '';
    $outOfQuotes = true;

    for ($i=0; $i<=$strLen; $i++) {

        // Grab the next character in the string.
        $char = substr($json, $i, 1);

        // Are we inside a quoted string?
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;

        // If this character is the end of an element, 
        // output a new line and indent the next line.
        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }

        // Add the character to the result string.
        $result .= $char;

        // If the last character was the beginning of an element, 
        // output a new line and indent the next line.
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }

            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }

        $prevChar = $char;
    }

    return $result;
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>XML to JSON using the Spark Convention</title>
	
<style type="text/css">

textarea {
	display : block;
	width : 60em;
	height : 30em;
}

#submit {
	margin-bottom : 3em;
	
}

</style>

</head>

<body>

<h3>XML to JSON Conversion using the Spark Convention</h3>
<ul>
	<li><a href="#">View documentation on the Spark Convention (nonexistant)</a></li>
	<li>View the source of this conversion script: <a href="xml2json_spark_php.txt">PHP</a> and <a href="xml2json_spark.xsl">XSL transformation rules</a></li>
</ul>

	<form method="POST" action="">
		
		<label for="xml">Enter some XML:</label>
		<textarea id="xml" name="xml" columns="50" rows="10"><?php	if($json) echo $xml_string; ?></textarea>

		<input id="submit" type="submit" value="Convert to JSON" />
	</form>



<?php

if($json) echo "<label>Your XML as JSON:</label><textarea>$json</textarea>";

?>
</body>
</html>