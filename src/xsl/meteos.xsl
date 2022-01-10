<?xml version='1.0' encoding="UTF-8" ?>
 <xsl:stylesheet version="1.0"
         xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
   <xsl:output method="text" encoding="UTF-8" indent="yes"/>
   <xsl:strip-space elements="*"/>
   


   <!-- On démarre de la racine -->
   <xsl:template match="/"> 
     <!-- On parcourt le sous-arbre dans l'ordre 'normal' -->
     <xsl:apply-templates />
   </xsl:template>
   
   <xsl:template match="previsions">
       <xsl:apply-templates />
   </xsl:template>
   
   <xsl:template match="echeance">
    <xsl:apply-templates />
</xsl:template>

</xsl:stylesheet>