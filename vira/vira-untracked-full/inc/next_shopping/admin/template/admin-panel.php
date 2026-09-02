<div class="wrap">
    <hr class="wp-header-end">
    <h1 class="wp-heading-inline "><?php _e('لیست خرید های آینده کاربران',NEXT_SHOPPING_LIST);?></h1>
    <form action="" method="post" style="display: inline-block;">

    </form>


    <hr class="wp-header-end">
<div>
    <ul class="subsubsub">
        <li class="all" >
            <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product&page=next_shopping_card_url' ) ); ?>"
               class="<?php echo (isset($_GET['post_status']))? '': 'current'; ?>">
                <?php _e('لیست خرید کاربران',NEXT_SHOPPING_LIST);?>
                <span class="count">(<?php echo count($DB->get_all()); ?>)</span>
            </a>
            |
        </li>
        <li class="wc-processing">
            <a href="<?php echo esc_url( admin_url( 'edit.php?post_status=wc-get-statistic&post_type=product&page=next_shopping_card_url' ) ); ?>"
               class="<?php if (isset($_GET['post_status'])) echo ($_GET['post_status'] == 'wc-get-statistic')? 'current': ''; ?> ">
                <?php _e('نمایش آمار',NEXT_SHOPPING_LIST);?>
                <span class="count">(<?php echo count($DB->get_groupby_all())?>)</span>
            </a>
            
        </li>

    </ul>
</div>
    

    <?php
    if (isset($_POST['download-excel'])){
        include NEXT_SHOPPING_LIST_ADMIN_TPL .'/get-excel.php' ;
    }
    if (isset($_GET['post_status'])){
        if ($_GET['post_status'] == 'wc-get-statistic'){
            include NEXT_SHOPPING_LIST_ADMIN_TPL .'/show-statistic-list.php' ;
        }else{
            include NEXT_SHOPPING_LIST_ADMIN_TPL .'/next-shoppingcart-list.php' ;
        }
    }else{
        include NEXT_SHOPPING_LIST_ADMIN_TPL .'/next-shoppingcart-list.php' ;
    }
    ?>
</div>
