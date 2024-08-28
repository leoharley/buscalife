        <table id="relatorioregra" class="table table-responsive table-bordered" border="1px" cellspacing="0" width="100%">
            <thead>
            <tr style="background: #2F75B5;color: #FFFFFF">
                <th>TbEmpresa_Id_Empresa</th>
                <th>Id_Convenio</th>
                <th>Cd_ConvenioERP</th>
                <th>Ds_Convenio</th>
                <th>Tp_Convenio</th>
                <th>dt_homolga_bi</th>
                <th>sn_homolog</th>
                <th>dt_reajuste</th>
                <th>Id_Plano</th>
                <th>Cd_PlanoERP</th>
                <th>Ds_Plano</th>
                <th>TbIndice_Id_Indice</th>
                <th>Ds_indice</th>
                <th>Vl_Indice</th>
                <th>Vl_M2Filme</th>
                <th>Vl_Honorário</th>
                <th>Vl_UCO</th>
                <th>TbRegra_Id_Regra</th>
                <th>Ds_Regra</th>
                <th>TbGrupoPro_CodGrupo</th>
                <th>Ds_GrupoPro</th>
                <th>Tp_GrupoPro</th>
                <th>Desc_Tp_GrupoPro</th>
                <th>TbFaturamento_Id_Faturamento</th>
                <th>Ds_Faturamento</th>
                <th>Tp_Faturamento</th>
                <th>Tp_TabFat</th>
                <th>Perc_Pago</th>
                <th>sn_faturanf</th>
                <th>qtde_fatitem</th>
            </tr>
            </thead>
            <tbody>
            <?php $x = 0; foreach ($exportacao as $registro) {?>
                <tr <?php if ($x++ % 2 == 0) {echo  ' style="background: #FFFFF;" ';} else {echo  ' style="background: #F0F0F0;" ';} ?>>
                    <td align="center"><?php echo $registro->TbEmpresa_Id_Empresa ?></td>
                    <td align="center"><?php echo $registro->Id_Convenio ?></td>
                    <td align="center"><?php echo $registro->Cd_ConvenioERP ?></td>
                    <td align="center"><?php echo $registro->Ds_Convenio ?></td>
                    <td align="center"><?php echo $registro->Tp_Convenio ?></td>
                    <td align="center"><?php echo $registro->dt_homolga_bi ?></td>
                    <td align="center"><?php echo $registro->sn_homolog ?></td>
                    <td align="center"><?php echo $registro->dt_reajuste ?></td>
                    <td align="center"><?php echo $registro->Id_Plano ?></td>
                    <td align="center"><?php echo $registro->Cd_PlanoERP ?></td>
                    <td align="center"><?php echo $registro->Ds_Plano ?></td>
                    <td align="center"><?php echo $registro->TbIndice_Id_Indice ?></td>
                    <td align="center"><?php echo $registro->Ds_indice ?></td>
                    <td align="center"><?php echo $registro->Vl_Indice ?></td>
                    <td align="center"><?php echo $registro->Vl_M2Filme ?></td>
                    <td align="center"><?php echo $registro->Vl_Honorário ?></td>
                    <td align="center"><?php echo $registro->Vl_UCO ?></td>
                    <td align="center"><?php echo $registro->TbRegra_Id_Regra ?></td>
                    <td align="center"><?php echo $registro->Ds_Regra ?></td>
                    <td align="center"><?php echo $registro->TbGrupoPro_CodGrupo ?></td>
                    <td align="center"><?php echo $registro->Ds_GrupoPro ?></td>
                    <td align="center"><?php echo $registro->Tp_GrupoPro ?></td>
                    <td align="center"><?php echo $registro->Desc_Tp_GrupoPro ?></td>
                    <td align="center"><?php echo $registro->TbFaturamento_Id_Faturamento ?></td>
                    <td align="center"><?php echo $registro->Ds_Faturamento ?></td>
                    <td align="center"><?php echo $registro->Tp_Faturamento ?></td>
                    <td align="center"><?php echo $registro->Tp_TabFat ?></td>
                    <td align="center"><?php echo $registro->Perc_Pago ?></td>
                    <td align="center"><?php echo $registro->sn_faturanf ?></td>
                    <td align="center"><?php echo $registro->qtde_fatitem ?></td>               
                </tr>
            <?php } ?>
            </tbody>
        </table>
    
        <br/><br/></p>

    <?php

    $data = new DateTime();
    //  echo $data->format('d-m-Y H:i:s');
    echo "Relatório gerado em: ".$data->format('d-m-Y').' às '.$data->format('H:i:s');
    echo '</p>';

    ?>