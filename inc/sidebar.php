 <!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">
   <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">
     <!-- sidebar menu: : style can be found in sidebar.less -->
     <form action="#" method="get" class="sidebar-form mobile-show">
       <div class="input-group">
         <input type="text" name="q" class="form-control" placeholder="Suche..." autocomplete="off">
         <span class="input-group-btn">
           <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
           </button>
         </span>
       </div>
     </form>
     <ul class="sidebar-menu" data-widget="tree">
       <li class="mobile-show"><a href="#search" class="cd-search-trigger">Advanced Search</a></li>
       <li class="mobile-show"><a href="#search" class="cd-search-trigger">Advanced Search</a></li>
        <!-- <li class="<?php if(preg_match("/quellenimport/", $actual_link)) echo 'active'; ?>">
          <a href="<?php echo $absoluteUrl;?>quellenimport">
            <i class="fa fa-sign-in"></i>
            <span>Quellenimport</span>
          </a>
        </li> -->
        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-line-chart"></i>
            <span>Quellenvergleich</span>
          </a>
        </li> -->
        <li class="<?php if(preg_match("/stammdaten/", $actual_link)) echo 'active'; ?> reset-datatable-state treeview"> 
          <a href="#">
            <i class="fa fa-database"></i>
            <span>Master data</span> <!-- Master Data -->
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
         <ul class="treeview-menu">
           <li class="<?php if (preg_match("/stop-words/", $actual_link)) echo 'active'; ?>"><a href="<?php echo $absoluteUrl; ?>dev-exp/stop-words.php"><i class="far fa-circle fa-xs"></i> Stop Words</a></li>
           <li class="<?php if (preg_match("/synonym-de/", $actual_link) or preg_match("/synonym-en/", $actual_link) or preg_match("/synonym-reference/", $actual_link)) echo 'active'; ?> reset-datatable-state treeview">
             <a href="#">
               <i class="far fa-circle fa-xs"></i>
               <span>Synonyms</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li class="<?php if (preg_match("/synonym-de/i", $actual_link)) echo 'active'; ?>"><a href="<?php echo $absoluteUrl; ?>dev-exp/synonym-de.php"><i class="far fa-circle fa-xs"></i> Synonym DE</a></li>
               <li class="<?php if (preg_match("/synonym-en/i", $actual_link)) echo 'active'; ?>"><a href="<?php echo $absoluteUrl; ?>dev-exp/synonym-en.php"><i class="far fa-circle fa-xs"></i> Synonym EN</a></li>
             </ul>
           </li>
         </ul>
       </li>
       <?php if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 1)) { ?>
         <li class="<?php if (preg_match("/einstellungen/", $actual_link)) echo 'active'; ?> treeview reset-datatable-state">
           <a href="#">
             <i class="fa fa-cog"></i>
             <span>User</span> <!-- user -->
             <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
             </span>
           </a>
           <ul class="treeview-menu">
             <li class="<?php if (preg_match("/benutzer/", $actual_link)) echo 'active'; ?>"><a href="<?php echo $absoluteUrl; ?>einstellungen/benutzer"><i class="far fa-circle fa-xs"></i> User</a></li>
           </ul>
         </li>
       <?php  } ?>
       <li class="<?php if(preg_match("/materia-medica/i", $actual_link)) echo 'active'; ?>">
          <a href="<?php echo $absoluteUrl;?>dev-exp/materia-medica.php">
            <i class="fa fa-heartbeat"></i>
            <span>Materia medica</span>
          </a>
        </li>
       </li>
     </ul>
   </section>
   <!-- /.sidebar -->
 </aside>