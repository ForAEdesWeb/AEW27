<?php

class articleslider
{
    public function getItems(&$params)
    {
        $db = JFactory::getDbo();
        $q = $db->getQuery(true);
        
        $ids = $params->get('acticle_id', "");
        $ids = $this->clearValue($ids);
        $sqlWhere = $this->getSqlValue($ids);
        
        $q->select("*")
            ->from("#__content as a");

        if (! empty($sqlWhere))
        {
            $q->where("a.id IN(" . $sqlWhere . ")");
        }

        $db->setQuery($q);

        return $db->loadObjectList();
    }

    public function clearValue($ids)
    {
        $ids = explode(",", $ids);
        $clearIds = array();

        foreach ($ids as $id)
        {
            $id = intval($id);

            if (0 !== $id)
            {
                $clearIds[] = $id;
            }
        }
        
        return $clearIds;
    }

    public function getSqlValue($ids)
    {
        if (! is_array($ids))
        {
            return null;
        }
        
        return implode(",", $ids);
    }
}

$url = $params->get("acticle_url", null);

if (empty($url))
{
    echo "you need to setup url";
}
else
{
    $thismod = new articleslider();

    $items = $thismod->getItems($params);

    require __DIR__ . '/tmpl/default.php';
}