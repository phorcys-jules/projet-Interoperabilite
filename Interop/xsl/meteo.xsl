<?xml version='1.0' encoding="UTF-8" ?>
 <xsl:stylesheet version="1.0"
		 xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
   <xsl:output method="html" encoding="UTF-8" indent="yes"/>
   <xsl:strip-space elements="*"/>

   <xsl:template match="/"> 
     <div>
       <xsl:apply-templates />  

	 </div>
   </xsl:template>

	<xsl:template match="previsions">
		<xsl:apply-templates select="echeance"/>
	</xsl:template>
   
   <xsl:template match="echeance">
   	<xsl:if test="@hour &gt; 0">
   		<xsl:if test="@hour &lt; 23">
   			<div id="cart">
   			<h3><xsl:text>Prévision pour le : </xsl:text><xsl:value-of select="@timestamp"/></h3>

			<ul>   
				<xsl:apply-templates select="temperature"/>
				<xsl:apply-templates select="vent_moyen/level"/>
				<xsl:apply-templates select="pluie"/>
				<xsl:apply-templates select="risque_neige"/>
				<br></br> 	
			</ul>		
   			</div>
   		</xsl:if>
	</xsl:if>
   </xsl:template>
   
   <xsl:template match="temperature">
	<li><xsl:text>Température : </xsl:text><xsl:value-of select="format-number(./level[2] - 273.15, '.00')" /><xsl:text>°C</xsl:text></li>
   </xsl:template>
    
   <xsl:template match="vent_moyen/level">
   	<li><xsl:text>Vent moyen : </xsl:text><xsl:value-of select="."/><xsl:text> m/s</xsl:text></li>
   </xsl:template>
   
   <xsl:template match="pluie">
   	<li><xsl:text>Risque de pluie : </xsl:text><xsl:value-of select="."/><xsl:text>%</xsl:text></li>
   </xsl:template>
  
   <xsl:template match="risque_neige">
   	<li><xsl:text>Risque de neige : </xsl:text><xsl:value-of select="."/></li>
   </xsl:template>

</xsl:stylesheet>
