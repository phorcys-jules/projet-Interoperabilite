<?xml version='1.0' encoding="UTF-8" ?>
 <xsl:stylesheet version="1.0"
         xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
   <xsl:output method="text" encoding="UTF-8" indent="yes"/>
   <xsl:strip-space elements="*"/>
   
   <xsl:variable name="Meteo" select="document('https://webetu.iutnc.univ-lorraine.fr/www/franco377u/interop/src/php')" />

   <!-- On démarre de la racine -->
   <xsl:template match="/"> 
     <!-- On parcourt le sous-arbre dans l'ordre 'normal' -->
     <xsl:apply-templates />
   </xsl:template>
   
   <xsl:template match="*">
       <xsl:apply-templates select="@*"/>
       <xsl:apply-templates />
   </xsl:template>
   
   <xsl:template match="@*">
     ATTRIBUT :
     <xsl:value-of select="."/>  
     <xsl:text>    </xsl:text>
   </xsl:template>

   <xsl:template match="text()">
     FEUILLE :
     <xsl:value-of select="."/>  
     <xsl:text>    </xsl:text>
   </xsl:template>

</xsl:stylesheet>