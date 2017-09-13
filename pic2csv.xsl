<?xml version="1.0"?>
<xsl:stylesheet version = "1.0" xmlns:xsl = "http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="text"/>

    <xsl:template match="/">
        <xsl:apply-templates />
    </xsl:template>

    <xsl:template match="table">
        <xsl:for-each select="tr/td">
            <xsl:if test="count(*)">
                <xsl:value-of select="concat('&#34;', normalize-space(h2/span/text()), '&#34;')"/><xsl:text>;</xsl:text>
                <xsl:if test=".//img">
                    <xsl:value-of select="concat('&#34;', .//img/@alt, '&#34;')"/><xsl:text>;</xsl:text>
                    <xsl:value-of select="concat('&#34;http:', .//img/@src, '&#34;')"/>
                </xsl:if>
                <xsl:text>
</xsl:text>
            </xsl:if>
        </xsl:for-each>

    </xsl:template>

</xsl:stylesheet>