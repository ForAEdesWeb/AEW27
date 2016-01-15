<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Priya bose - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
/** Check to ensure this file is included in Joomla! */
defined('_JEXEC') or die( 'Restricted access' );
$remove_pricefilter_url = "index.php";

// 眼花懶得看 joomla or j2store 怎麼吃模板了，有空再改
class lazyTemplates
{
	public $category;
	public $hiddenCategory;
	public $hiddenContent;

	public function getItem()
	{
		$html = "<li class=\"j2product_categories level{$this->category->level}\">";
		$title = $this->getTitle($this->category->title);

		$href = $this->getHref($title);

		if (in_array($this->category->id, $this->hiddenCategory))
		{
			$href = $this->getHiddenButton($title, $this->hiddenContent);
		}

		$html .=  $href;
		$html .= "</li>";

		return $html;
	}

	public function getCategoryImage()
	{
		$categoryParams = json_decode($this->category->params);

		if(! isset($categoryParams->image) or empty($categoryParams->image))
		{
			return "";
		}

		return "<img class=\"j2store-category-icon\" src=\"{$categoryParams->image}\" />";
	}

	public function getTitle()
	{
		$level = str_repeat("<span class='space'></span>", $this->category->level);
		$images = $this->getCategoryImage();

		return "<span class=\"j2store-item-rootcategory\">{$level}{$images}{$this->category->title}</span>";
	}

	public function getHref($content)
	{
		$url = JRoute::_("&filter_category={$this->category->id}&category_title={$this->category->title}");

		return "<a href=\"{$url}\">{$content}</a>";
	}

	public function getHiddenButton($content, $hiddenContent = "")
	{
		return "{$content}<a class='AEHiddenCategory'>{$hiddenContent}</a>";
	}

	public function getUl($content)
	{
		return "<ul class='j2store_hidden_categories'>{$content}</ul>";
	}
}

class treeCategories
{
	public $categories;
	public $hiddenCategory;

	public function getChilds($parentCat)
	{
		$childCats = array();

		foreach ($this->categories as $childCat)
		{
			if ($childCat->parentCat->id == $parentCat->id)
			{
				$childCats[] = $childCat;
			}
		}

		return $childCats;
	}

	public function getTree()
	{
		$template = new lazyTemplates();
		$template->hiddenCategory = $this->hiddenCategory;

		$li = "";

		foreach ($this->categories as $cat)
		{
			$childs = $this->getChilds($cat);
			$template->hiddenContent = "";
			$template->category = $cat;

			// 有女
			if (! empty($childs))
			{
				$tree = new treeCategories();
				$tree->categories = $childs;
				$tree->hiddenCategory = $this->hiddenCategory;

				$template->hiddenContent = $tree->getTree();
				$li .= $template->getItem();
			}
		}

		return $template->getUl($li);
	}
}
?>

<div class="j2store-product-filter-modules">
	<!-- Modules  Price Filters  Start here-->
	<?php if(count(JModuleHelper::getModules('j2store_module_pricefilters'))): ?>
	<div class="j2store-product-filters price-filters">
		<?php  echo J2StoreHelperModules::loadposition('j2store_module_pricefilters');?>
	</div>
	<?php endif; ?>

	<?php if($this->layoutparams->get('show_product_list_filter_category', 0)): ?>
	<!-- Module Categories Filters -->
	<div class="j2store-product-filters category-filters">
		<h4><?php echo JText::_('J2STORE_CATEGORY_FILTER_TITTLE'); ?></h4>
		<div id="j2store_category">
		<ul id="j2store_categories_mod" class="unstyled nav nav-stacked">
			<?php
				$tree = new treeCategories();
				$tree->hiddenCategory = $this->filters['filter_hidden_categories'];

				foreach ($this->filters['filter_tree_categories'] as $item)
				{
					if ($item->isRoot)
					{
						$tree->categories = array($item);

						echo $tree->getTree();
					}
				}
			?>
		</ul>
		</div>

	</div>
	<?php endif; ?>

<?php if($this->layoutparams->get('show_product_list_filter_price', 0) && isset($this->ranges) && $this->ranges): ?>

	<div class="j2store-price-filters">
	<h4><?php echo JText::_('J2STORE_PRICE_FILTER_TITTLE'); ?></h4>
	<ul id="j2store_pricefilter_mod" class="unstyled nav nav-stacked nav-bar">
		<?php $i = 1;?>
		<?php foreach ($this->ranges as $link => $range ) : ?>
			<?php

			$app = JFactory::getApplication();
			$selected = $app->input->get('rangeselected') ?>
			<?php $class = ($selected == $i) ? 'range selected' : 'range';?>
			<li class="product_price_filters <?php echo $class;?>"  >
				<a href="<?php echo JRoute::_( "{$link}&rangeselected=".$i ); ?>">
					<span class="price-range"> <?php echo $range; ?></span>
				</a>
			</li>
		<?php $i++;?>
		<?php endforeach; ?>
		<div class="j2store-pricefilters-remove">
			<a href="<?php echo JRoute::_( $remove_pricefilter_url ); ?>"><?php echo JText::_('J2STORE_REMOVE_FILTER') ?></a>
		</div>
		</ul>
	</div>
<?php endif; ?>

<?php if($this->layoutparams->get('show_product_list_filter_tag', 0)): ?>
<div id="j2store-filter-tags">
	<h4><?php echo JText::_('J2STORE_TAG_FILTER_TITTLE'); ?></h4>
	<ul class="unstyled nav nav-stacked">
	<?php foreach ($this->product_tags as $i =>$tag) : ?>
		<li class="j2product-producttags-<?php echo $i;?>">
			<a href="<?php echo JRoute::_("&filter_tag_title=".$tag->text."&filter_tag=".$tag->value)?>">
				<?php echo $tag->text; ?>
			</a>
		</li>
	<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>

	<?php if(count(JModuleHelper::getModules('j2store_module_tags'))): ?>
		<!-- Module Tags Filters -->
		<div class="j2store-product-filters tags-filters">
				<?php echo J2StoreHelperModules::loadposition('j2store_module_tags');?>
		</div>
	<?php endif; ?>

</div>
