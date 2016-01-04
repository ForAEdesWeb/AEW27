<?php

class articleslider_display
{
    public function getArticleIntroImage($article)
    {
        return json_decode($article->images)->image_intro;
    }

    public function getArticleUrl($url, $id)
    {
        return str_replace("{id}", $id, $url);
    }

    public function htmlSkip($modHtml)
    {
        $modHtml = str_replace("{", "<", $modHtml);
        $modHtml = str_replace("}", ">", $modHtml);

        return $modHtml;
    }
}

$tempDisplay = new articleslider_display();
?>

<style>
    #marquee-items {
        max-width: 100%;
        padding: 1%;
        overflow: hidden;
        white-space: nowrap;
        clear: both;
    }
    #marquee-items .item {
        max-width: 350px;
        min-width: 200px;
        width: 10%;
        margin: 0 1% 0 0;
        background-color: #777;
        border: 4px solid #777;
        border-radius: 0 0 15px 15px;
        text-align: center;
        vertical-align: top;
        display: inline-block;
    }
    #marquee-items .item:hover {
        background-color: #ff0000;
        border: 4px solid #ff0000;
        margin: -1% 0% 1% -1%;
        max-width: 400px;
        min-width: 250px;
        width: 12%;
    }
    #marquee-items .item img {
        max-width: 100%;
        border: 0;
    }
    #marquee-items .item h4 {
        font-size: 1.1em;
        color: #fff;
        max-width: 100%;
        margin: 0;
        padding: 6px;
        white-space: normal;
        min-height: 55px;
    }
    #marquee-items .item:hover h4 {
        color: #eee;
    }
</style>

<div class="row">
    <div class="col-xs-1 text-center" id="marquee-left">
        <?php
        $leftButtonDisplay = $params->get("left_button_display", "left");

        echo $tempDisplay->htmlSkip($leftButtonDisplay);
        ?>
    </div>
    <div class="col-xs-10">
        <div id="marquee-items">
            <?php $doubleItems = array_merge($items, $items); ?>

            <?php foreach($doubleItems as $article): ?>
                <div class="item">
                    <?php $thisUrl = $tempDisplay->getArticleUrl($url, $article->id); ?>

                    <a href="<?php echo $thisUrl; ?>">
                        <img src="<?php echo $tempDisplay->getArticleIntroImage($article); ?>" />
                    </a>

                    <a href="<?php echo $thisUrl; ?>">
                        <h4><?php echo $article->title; ?></h4>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-xs-1 text-center" id="marquee-right">
        <?php
        $rightButtonDisplay = $params->get("right_button_display", "right");

        echo $tempDisplay->htmlSkip($rightButtonDisplay);
        ?>
    </div>
</div>

<script>
    var objectId = "#marquee-items";
    var moveItem = jQuery(objectId + " .item:first-child");
    var allItem = jQuery(objectId + " .item");
    var direction = 'left';
    var speed = <?php echo $params->get("speed", 100); ?>;
    var totalWidth = 0;
    var nowDistance = 0;
    var status = "start";

    allItem.each(function(){
        totalWidth += jQuery(this).width();
        totalWidth += parseFloat(jQuery(this).css("margin-right"));
    });

    totalWidth = totalWidth / 2;

    function ae_marquee()
    {
        if ("stop" == status)
        {
            setTimeout("ae_marquee();", speed);
            return true;
        }

        if ("left" == direction)
            nowDistance -= 1;
        else
            nowDistance += 1;

        if (nowDistance < (-1 * totalWidth))
        {
            nowDistance = 0;
        }

        if (nowDistance > 0)
        {
            nowDistance = (-1 * totalWidth);
        }

        moveItem.css("margin-left", nowDistance.toString() + "px");

        setTimeout("ae_marquee();", speed);
        return true;
    }

    jQuery(objectId).hover(function(){
        status = "stop";
    }, function(){
        status = "start";
    });

    jQuery("#marquee-left").hover(function(){
        direction = 'left';
    });

    jQuery("#marquee-right").hover(function(){
        direction = 'right';
    });

    ae_marquee();
</script>