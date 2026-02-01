Link Class
==========

.. php:class:: Link

    Represents a Link between two node(s) and/or sub-graph(s)

    .. php:method:: __construct(LinkableInterface $from, LinkableInterface $to, LinkStyle $style = LinkStyle::solid, int $minLength = 1, ArrowHead $arrowHead = ArrowHead::arrow)

        Creates a Link between two node(s) and/or sub-graph(s)

        :param LinkableInterface $from: The object the link is from
        :param LinkableInterface $to: The object the link is to
        :param LinkStyle $style: The link style (default: :php:case:`LinkStyle::solid`)

        .. note::

            The remaining parameters are ignored if $style === :php:case:`LinkStyle::invisible`

        :param int $minLength: The minimum link length (default: 1)
        :param ArrowHead $arrowHead: The link's arrowhead (default: ArrowHead::arrow)
        :param bool $biDirection: Whether the link is bidirectional (default: unidirectional)
        :returns: A new instance of ``Link``
        :rtype: Link

    .. php:method:: bidirectional()

        Make the link bidirectional

        :returns: A new instance of ``Link`` that is bidirectional
        :rtype: Link
        :throws: RuntimeException on render if $style === :php:case:`LinkStyle::invisible`

    .. php:method:: withEdgeId(EdgeId $edgeId)

        Sets an edge id

        :param EdgeId $edgeId: The edge id
        :returns: A new instance of ``Link`` that has an edge id
        :rtype: Link
        :throws: RuntimeException on render if $style === :php:case:`LinkStyle::invisible`

    .. php:method:: withText(string $text)

        Add text to the link

        :param string $text: The text
        :returns: A new instance of ``Link`` with the text
        :rtype: Link
        :throws: RuntimeException on render if $style === :php:case:`LinkStyle::invisible`
