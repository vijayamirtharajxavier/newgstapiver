
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url();?>index.html">
        <div class="sidebar-brand-icon rotate-n-15">
         <!-- <i class="fas fa-laugh-wink"></i> -->
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $this->session->userdata('cname'); ?> <sup></sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url();?>dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Inventory
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url();?>#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Masters</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Goods & Services</h6>
            <a class="collapse-item" href="<?php echo base_url();?>group">Groups</a>
            <a class="collapse-item" href="<?php echo base_url();?>products">Products & Services</a>
            <a class="collapse-item" href="<?php echo base_url();?>ledgers">Ledger Accounts</a>
            <a class="collapse-item" href="<?php echo base_url();?>ledgers/openbal">Opening Balance</a>
            
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url();?>#" data-toggle="collapse" data-target="#collapseInventory" aria-expanded="true" aria-controls="collapseInventory">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Inventory Transaction</span>
        </a>
        <div id="collapseInventory" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Inventory</h6>
            <a class="collapse-item" href="<?php echo base_url();?>inventory/purreg">Purchase / Inward</a>
            <a class="collapse-item" href="<?php echo base_url();?>inventory/salesreg">Sales / Outwards</a>
<!--            <a class="collapse-item" href="<?php echo base_url();?>inventory/newdebitnote">Debit Note</a>

            <a class="collapse-item" href="<?php echo base_url();?>inventory/newcreditnote">Credit Note</a> -->
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Accounts
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url();?>#" data-toggle="collapse" data-target="#collapseAccounts" aria-expanded="true" aria-controls="collapseAccounts">
          <i class="fas fa-fw fa-folder"></i>
          <span>Accounts Transaction</span>
        </a>
        <div id="collapseAccounts" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Receipts & Payments</h6>
            <a class="collapse-item" href="<?php echo base_url();?>accounts/receipts">Receipts</a>
            <a class="collapse-item" href="<?php echo base_url();?>accounts/payments">Payments</a>
          <a class="collapse-item" href="<?php echo base_url();?>accounts/contra">Contra</a>
          <a class="collapse-item" href="<?php echo base_url();?>accounts/journals">Journal</a>

          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url();?>#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports">
          <i class="fas fa-fw fa-folder"></i>
          <span>Reports</span>
        </a>
        <div id="collapseReports" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Reports:</h6>
            <a class="collapse-item" href="<?php echo base_url();?>reports/gledger">General Ledger</a>
            <a class="collapse-item" href="<?php echo base_url();?>reports/cashbank">Cash / Bank Report</a>
             <a class="collapse-item" href="<?php echo base_url();?>reports/cwms">Monthwise Clnt. Sumry</a>
             <a class="collapse-item" href="<?php echo base_url();?>inventory/salesregister">Sales /Purchase  Register</a>

<hr class="sidebar-divider">
          <!--   <a class="collapse-item" href="<?php echo base_url();?>reports/trialbal">Trial Balance</a>


<hr class="sidebar-divider">
            <a class="collapse-item" href="<?php echo base_url();?>reports/gstr1">GSTR1 Return</a>

            <a class="collapse-item" href="<?php echo base_url();?>reports/gstr2b">GSTR2B Return</a>
            <a class="collapse-item" href="<?php echo base_url();?>reports/gstr3b">GSTR3B Return</a> -->

          </div>
        </div>
      </li>



      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        GST
      </div>


      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url();?>#" data-toggle="collapse" data-target="#collapseGst" aria-expanded="true" aria-controls="collapseGst">
          <i class="fas fa-fw fa-folder"></i>
          <span>GST Returns</span>
        </a>
        <div id="collapseGst" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">GST Returns:</h6>
            <a class="collapse-item" href="<?php echo base_url();?>reports/gstr1">GSTR1 Return</a>

            <a class="collapse-item" href="<?php echo base_url();?>reports/gstr2b">GSTR2B Return</a>
            <a class="collapse-item" href="<?php echo base_url();?>reports/gstr3b">GSTR3B Return</a>
            <a class="collapse-item" href="<?php echo base_url();?>reports/gstr3bsum">GSTR3B Summary</a>
            <a class="collapse-item" href="<?php echo base_url();?>reports/gstr9return">GSTR9-Annual Return</a>


          </div>
        </div>
      </li>



      <!-- Nav Item - Charts --
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>

      <!-- Nav Item - Tables --
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>

      <!-- Divider --
      <hr class="sidebar-divider d-none d-md-block"> -->

      <!-- Sidebar Toggler (Sidebar) --
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>  -->

    </ul>
    <!-- End of Sidebar -->

