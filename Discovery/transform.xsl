<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html"/>

<xsl:template match="discovery">
 <html>
	<head>
		
		<style type="text/css">
			
			body {
			font-family : sans-serif;
			color : #333333;
			font-size : .85em;
			}

			a {
			color : #3080CB;
			}

			table, th, td {
			border : 1px solid #A8A8A8;
			}

			table {
			width : 800px;
			margin : 1em auto;
			border-width : 0 0 1px 1px;
			}

			th {
			text-align : left;
			border-width : 1px 1px 0 0;
			background-color : #ccc;
			color : #000;
			padding : .5em;
			font-weight : normal;
			}

			td {
			border-width : 1px  1px 0 0;
			padding : .5em;
			}

			ul, li {
			list-style-type : none;
			padding : 0;
			margin : 0;
			}

			.production .type {
			color : #A4B300;
			}

			.test .type {
			color : #CC210A;
			}



		</style>
	</head>			
			
	
 <body>

	 <table border="0" cellpadding="0" cellspacing="0">
		
		<tr>
			<th>Changeset</th>
			<td><xsl:value-of select="changeset"/></td>
		</tr>
		<tr>
			<th>Contact</th>
			<td><xsl:value-of select="contact"/></td>
		</tr>
		<tr>
			<th>Key Service</th>
			<td><xsl:value-of select="key_service"/></td>
		</tr>				
	</table>


 <table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th>Specification/Namespace</th>
		<th>URL</th>
		<th>Changeset</th>				
		<th>Type</th>				
		<th>Formats</th>				
	</tr>
	
 <xsl:for-each select="endpoints/endpoint">
  <xsl:sort select="specification"/>

<xsl:if test="specification = 'http://wiki.open311.org/GeoReport_v2'">

  <tr class="{type}">
  <td><xsl:value-of select="specification"/></td>
  <td><a href="#"><xsl:value-of select="url"/></a></td>
  <td><xsl:value-of select="changeset"/></td>
  <td class="type"><xsl:value-of select="type"/></td>
  <td>
	<ul>
	 <xsl:for-each select="formats/format">	
		<li><xsl:value-of select="."/></li>
 	</xsl:for-each>
	</ul>
  </td>

  </tr>

</xsl:if>
 </xsl:for-each>

</table>
 </body>
 </html>
</xsl:template>
</xsl:stylesheet>