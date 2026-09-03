<?php if ( ! defined( 'ABSPATH' ) ) {exit;}?>
<?php if($ptcount>0){ ?>
    <div class="tab-pane" id="ContentD">
        <div class="col-lg-12">
            <style>
            <?php if(get_locale()=="ja"){
                echo ".pt_us{display:none}";
            }else{
                echo ".pt_jp{display:none}";
            }
            ?>
            </style>
            <p><?php _e("Malwares continue increasing day by day with overcoming pattern definition of security softwares. It is recommended to apply the latest pattern to your website to obtain maximum security protection.","wpinfecscan");?></p>
            <?php
                
                $ptdata = get_option( 'wpinfectscanner_newpatterndetail');
                $ptdata=json_decode($ptdata);
                
                if(count($ptdata)>0){

                    echo "<table class='table'>";
                    echo "<thead><tr><th scope='col'>". __("Type","wpinfecscan")."</th><th scope='col'>". __("Patterns","wpinfecscan")."</th><th scope='col'>". __("Explanation","wpinfecscan")."</th><th scope='col'>". __("Added date","wpinfecscan")."</th></tr></thead><tbody>";
                    for($i=0;$i<count($ptdata);$i++){
                        $day = explode(" ",$ptdata[$i]->adddate);
                        $patterntype=__("File","wpinfecscan");
                        if($ptdata[$i]->id>1000000){
                            $patterntype=__("Database","wpinfecscan");
                        }
                        echo "<tr><td>".$patterntype."</td><td>".htmlspecialchars ($ptdata[$i]->pattern)."</td><td>".$ptdata[$i]->pname."</td><td>".$day[0]."</td></tr>";
                    }
                    echo "</tbody></table>";
                    echo "<p>". __("*Display up to 50 results","wpinfecscan")."</p>";
                    
                }
            ?>
        </div>
    </div>
<?php } ?>