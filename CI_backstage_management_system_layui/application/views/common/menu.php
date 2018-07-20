<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.check('main-container', 'fixed')
        } catch (e) {
        }
    </script>
    <div class="main-container-inner">
        <div class="sidebar" id="sidebar">
            <script type="text/javascript">
                try {
                    ace.settings.check('sidebar', 'fixed')
                } catch (e) {
                }
            </script>
            <ul class="nav nav-list">
                <?php
                    if ($nav && is_array($nav)) {
                        foreach ($nav as $v) {
                            if (empty($v['_data'])) { ?>
                                <li class="b-nav-li"><a href="<?php echo site_url($v['name']); ?>"><i class="fa fa-<?php echo $v['ico']; ?> icon-test"></i> <span
                                    class="menu-text"><?php echo $v['title']; ?></span></a></li>
                            <?php
                            } else { ?>
                                <li class="b-has-child"><a href="#" class="dropdown-toggle b-nav-parent" data-title="<?=$v['title']?>"><i
                                                class="fa fa-<?php echo $v['ico']; ?> icon-test"></i> <span class="menu-text"><?php echo $v['title']; ?></span><b
                                                class="arrow icon-angle-down"></b></a>
                                    <ul class="submenu">
                                        <?php
                                            foreach ($v['_data'] as $n) { ?>
                                                <li class="b-nav-li "><a data-title="<?=$n['title']?>"
                                                    href="<?php echo site_url($n['name']); ?>"><i class="icon-double-angle-right"></i>
                                                <?php echo $n['title']; ?></a></li>
                                            <?php }
                                        ?>
                                    </ul>
                                </li>
                            <?php }
                        }
                    }
                ?>
            </ul>
            <script type="text/javascript">
                try {
                    ace.settings.check('sidebar', 'collapsed')
                } catch (e) {
                }
            </script>
        </div>
        <div class="main-content">
            <div class="page-header">
                <h1><i class="fa fa-home"></i><span class="bread_crumb"></span></h1>
            </div>
            <div class="page-content">




