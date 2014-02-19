<div id="tabs">
    <ul>
        <li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>                   
    </ul>
        <div id="tabs-1">
            <?php if($error_mensaje) {                     
                echo $error_mensaje['error'];
            }
            else
            { ?>
                <div>Se enviara la encuesta a los siguientes desinatarios</div>
                <div>
                <?php
                    foreach($info_csv as $fields_csv)
                    {
                        echo '<div>' . $fields_csv['Nombre'] . ' ' . $fields_csv['Apellido'] . '</div>';
                    }
                ?>  
                </div>
                <?php  
            }
            ?>
        </div>
    <div id="tabs-2">
    </div>
</div>

