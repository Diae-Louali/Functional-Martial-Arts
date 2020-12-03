<?php $registerPage = '/Functional-Martial-Arts/RegisterFMA.php' ?>
<div id='HEADERNavbar' class='MasterContainer'>
    <nav id='navbar' class='navbar'>
        <div id='BRANDcontainer' class=' BrandFMA d-flex flex-column vlhrparent justify-content-center'>
            <div id='MaindivBRAND' class='d-flex align-items-center h-100'>
                <div class='vlBRAND pr-xl-5 pr-lg-4 pr-md-3 pr-sm-2'></div>
                <img src='Images\FunctionalMartialArtsLOGO.png' class='rounded-circle' alt=''>
                <a class='brandlink pr-xl-5 pr-lg-4 pr-md-3 pr-sm-2' href='#/'>FMA</a>
                <div class='vlBRAND'></div>
            </div>
            <div id='HrDivBRAND' class='d-flex justify-content-center position-relative'>
                <hr class='hrBRAND position-absolute'>
            </div>    
            <a href="HomeFMA.php" class="link-area"><span class="clickeable-area"></span></a>                             
        </div>
        <a href='#/' id='HAMBURGER' class='toggle-button mt-2'>
            <span class='bar'></span>
            <span class='bar'></span>
            <span class='bar'></span>
        </a>
        <div id='NAV-LINKS' class='navbar-links'>
            <ul>
                <li class='d-flex vlhrparent'>
                    <div class='vl'></div>
                    <div class='Adiv d-flex flex-column'><a href='HomeFMA.php'> Home</a><hr class='align-self-center'></div>
                    <div class='vl pr-xl-4 pr-lg-3 pr-md-2'></div>
                </li>
                <li class='d-flex vlhrparent'>
                    <div class='vl'></div>
                    <div class='Adiv d-flex flex-column'><a href='ArticleFMA.php'> Article</a><hr class='align-self-center'></div>
                    <div class='vl pr-xl-4 pr-lg-3 pr-md-2'></div>
                </li>
                <li class='d-flex vlhrparent'>
                    <div class='vl'></div>
                    <div class='Adiv d-flex flex-column'><a href='AboutFMA.php'> About</a><hr class='align-self-center'></div>
                    <div class='vl pr-xl-4 pr-lg-3 pr-md-2'></div>
                </li>
                <?php if (isset($_SESSION['Connected-UserID'])):
                        if ($_SESSION["Connected-UserRole"] === "Admin"){?>
                            <li class='d-flex vlhrparent'>
                                <div class='vl'></div>
                                <div class='Adiv d-flex flex-column'><a href='AdminFMA.php'> Dashboard</a><hr class='align-self-center'></div>
                                <div class='vl pr-xl-4 pr-lg-3 pr-md-2'></div>
                            </li>
                        <?php } ?>
                    <li id='dropContainerID' class='d-flex vlhrparent'>
                        <div class='vl vlfordropdown'></div>
                        <div class='Adiv d-flex flex-column dropdown show'>
                            <a href='#/' id='dropToggleID' class='dropdown-toggleCustom' role='button' ><img style='width:27px; height: 27px;' class='rounded-circle bg-white navpfp' src='<?php echo "uploads/" . $_SESSION["Connected-UserPfp"];?>'>
                                <?php echo $_SESSION["Connected-UserUsername"]; ?><i class='Arrow-Icon fas fa-chevron-down'></i>
                            </a><hr id='hrForMainContainer' class='align-self-center hrForMainContClass'>           
                            <ul id='dropmenuID' class='Adiv d-flex flex-column dropdown-menuCUSTOM'>
                                <a  class='d-flex vlhrparent dropdown-itemCustom p-0 m-0'>
                                    <div class='Adiv d-flex flex-column dropdown-link'><a id='dropdown-itemID1' href='ProfileFMA.php'> Profil</a><hr class='hrfordropdown align-self-center'></div>
                                </a>
                                <a  class='d-flex vlhrparent dropdown-itemCustom p-0 m-0'>
                                    <div class='Adiv d-flex flex-column dropdown-link'><a id='dropdown-itemID2' href='#/' data-toggle='modal' data-target='#LogOutModal'> Log out</a><hr class='hrfordropdown align-self-center'></div>
                                </a>            
                            </ul>                                                                  
                        </div>
                        <div class='vl vlfordropdown pr-xl-4 pr-lg-3 pr-md-2'></div>
                    </li>
                <?php else:?>
                    <li class='d-flex vlhrparent'>
                        <div class='vl'></div>
                        <div class='Adiv d-flex flex-column'> 
                            <a <?php if ($_SERVER['REQUEST_URI'] === $registerPage){ ?>
                                href='LoginFMA.php'
                            <?php } else { ?>
                                href='#/' data-toggle='modal' data-target='#LoginModal'
                            <?php } ?>> Sign in</a><hr class='align-self-center'>
                        </div>                                                                                                                                         
                        <div class='vl pr-xl-4 pr-lg-3 pr-md-2'></div>
                    </li>
                    <li class='d-flex vlhrparent'>
                        <div class='vl'></div>
                        <div class='Adiv d-flex flex-column'><a href='RegisterFMA.php'> Register</a><hr class='align-self-center'></div>
                        <div class='vl pr-xl-4 pr-lg-3 pr-md-2'></div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>