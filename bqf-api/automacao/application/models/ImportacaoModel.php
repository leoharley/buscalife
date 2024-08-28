<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ImportacaoModel extends CI_Model
{

    function carregaInfoGrupoPro($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbGrupoPro as GrupoPro');
        $this->db->where('GrupoPro.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('GrupoPro.Deletado !=', 'S');
        $this->db->where('GrupoPro.Tp_Ativo', 'S');
        $this->db->order_by('GrupoPro.Tp_GrupoPro', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaGrupoPro($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('TbGrupoPro', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }

    function adicionaSimproMae($info)
    {
        $this->db->trans_start();
        $this->db->insert('TbSimpro', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function adicionaBrasindiceMae($info)
    {
        $this->db->trans_start();
        $this->db->insert('TbBrasindice', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }


    function adicionaSimproMsg($info)
    {
    //    $this->db->trans_start();
        $insert = $this->db->insert('TbSimproMsg', $info);

        $insert_id = $this->db->insert_id();

    //    $this->db->trans_complete();

        return $insert;
    }

    function carregaInfoProFat($idEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('TbProFat as ProFat');
        $this->db->where('ProFat.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('ProFat.Deletado !=', 'S');
        $this->db->where('ProFat.Tp_Ativo', 'S');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }

    /*function adicionaProFat($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('TbProFat', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }*/


   /* function verExisteSimpro()
    {
        $this->db->reconnect();
        $this->db->start_cache();
        $sql="select tfi.\"Id_FatItem\", tfi.\"Cd_TISS\" from \"TbFatItem\" tfi 
        inner join \"TbSimpro\" ts on (ts.\"Cd_Simpro\" = tfi.\"Cd_TISS\" AND ts.\"Tp_Alteracao\" IN ('P','A'))
        inner join \"TbFaturamento\" tf on (tf.\"Id_Faturamento\" = tfi.\"TbFaturamento_Id_Faturamento\" AND tf.\"Tp_TabFat\" IN ('SPFB','SPMC'))";
        $query = $this->db->query($sql);
        $this->db->stop_cache();
        $this->db->flush_cache();
        return $query;
    }*/

 /*   function verCondInclFatItemPelaSimpro($cdSimpro)
    {
        $this->db->reconnect();
        $this->db->start_cache();
        $sql="SELECT FatItem.\"Id_FatItem\", FatItem.\"Cd_TISS\" FROM \"TbFatItem\" FatItem 
        INNER JOIN \"TbSimpro\" Simpro ON Simpro.\"Cd_Simpro\" = FatItem.\"Cd_TISS\" AND Simpro.\"Tp_Alteracao\" IN ('P','A') 
        INNER JOIN \"TbFaturamento\" Faturamento ON Faturamento.\"Id_Faturamento\" = FatItem.\"TbFaturamento_Id_Faturamento\" AND Faturamento.\"Tp_TabFat\" IN ('SPFB','SPMC') 
        WHERE FatItem.\"Cd_TISS\" = '{$cdSimpro}'";
        $query = $this->db->query($sql);

        $this->db->stop_cache();
        $this->db->flush_cache();
        return $query;
    } */

  function verCondPrecoAltFatItemPelaSimpro($cdSimpro,$numeroMsg)
    {
        $this->db->select('FatItem.Id_FatItem, FatItem.Cd_TISS');
        $this->db->from('TbFatItem as FatItem');
        $this->db->join('TbSimpro as Simpro', 'Simpro.Cd_Simpro = FatItem.Cd_TISS AND Simpro.Tp_Alteracao IN (\'P\',\'A\')','inner');
        $this->db->join('TbFaturamento as Faturamento', 'Faturamento.Id_Faturamento = FatItem.TbFaturamento_Id_Faturamento AND Faturamento.Tp_TabFat IN (\'SPFB\',\'SPMC\')','inner');
        $this->db->where('FatItem.Cd_TISS', $cdSimpro);
        $this->db->where('Simpro.NumeroMsg', $numeroMsg);
        $query = $this->db->get();
	    
        return $query->result();
    } 

  /*  function verCondInclFatItemPelaSimpro($cdSimpro)
    {
        $this->db->select('FatItem.Id_FatItem, FatItem.Cd_TISS');
        $this->db->from('TbFatItem as FatItem');
        $this->db->join('TbSimpro as Simpro', 'Simpro.Cd_Simpro = FatItem.Cd_TISS AND Simpro.Tp_Alteracao IN (\'I\')','inner');
        $this->db->join('TbFaturamento as Faturamento', 'Faturamento.Id_Faturamento = FatItem.TbFaturamento_Id_Faturamento AND Faturamento.Tp_TabFat IN (\'SPFB\',\'SPMC\')','inner');
        $this->db->where('FatItem.Cd_TISS', $cdSimpro);
        $query = $this->db->get();

        return $query->result();
    } */

    function verCondInclFatItemPelaSimpro ($cdSimpro,$idFaturamento,$numeroMsg)
    {
        $this->db->reconnect();
        $sql="SELECT TbFaturamento.\"Id_Faturamento\" \"TbFaturamento_Id_Faturamento\",
        TbFaturamento.\"TbEmpresa_Id_Empresa\" \"TbEmpresa_Id_Empresa\",
        TbSimpro.\"Cd_Simpro\" \"Cd_TISS\",
        (CASE WHEN TbSimpro.\"Cd_TUSS\" = '' THEN TbSimpro.\"Cd_Simpro\" ELSE TbSimpro.\"Cd_TUSS\" END) \"Cd_TUSS\",
        TbSimpro.\"Ds_Produto\" \"Ds_FatItem\",  
               (CASE WHEN TbFaturamento.\"Tp_TabFat\" = 'SPFB' 
                     then (case when TbSimpro.\"ProdFracao_SN\" = 'S' 
                               THEN TbSimpro.\"Pr_FabFracao\" 
                               else TbSimpro.\"Pr_FabEmbalagem\" 
                          end) 
                     else (case when TbFaturamento.\"Tp_TabFat\" = 'SPMC' 
                               then (case when TbSimpro.\"ProdFracao_SN\" = 'S' 
                                         THEN TbSimpro.\"Pr_VenFracao\" 
                                         else TbSimpro.\"Pr_VenEmbalagem\"
                                     end)
                          end)
                 end) \"Vl_Total\",
        TbSimpro.\"Qt_Embalagem\" as \"Qt_Embalagem\", 
        case when TbSimpro.\"ProdFracao_SN\" = 'S' 
             then TbSimpro.\"Tp_Fracao\" 
             else TbSimpro.\"Tp_Embalagem\" 
        end \"Ds_Unidade\",
        TbSimpro.\"DT_Vigencia\" \"Dt_IniVigencia\", 
        TbSimpro.\"Dt_Ativo\" \"Dt_Ativo\", 
        TbSimpro.\"Tp_Ativo\" \"Tp_Ativo\",
        TbSimpro.\"NumeroMsg\" \"Ds_Motivo_alteracao\"
        FROM 
        \"TbSimpro\" TbSimpro
 --       left outer join \"TbFatItem\" tbfatitem on (tbfatitem.\"Cd_TISS\" != TbSimpro.\"Cd_Simpro\")
        left outer join  \"TbFaturamento\" TbFaturamento on (TbFaturamento.\"Id_Faturamento\" = {$idFaturamento} and TbFaturamento.\"Tp_TabFat\" in ('SPMC','SPFB' ))
        WHERE 
        TbSimpro.\"Cd_Simpro\" = '{$cdSimpro}' AND
        TbSimpro.\"Tp_Alteracao\" = 'I' AND
        TbFaturamento.\"Tp_TabFat\" is not NULL AND
        TbSimpro.\"NumeroMsg\" = '{$numeroMsg}'
        group by (CASE WHEN TbSimpro.\"Cd_TUSS\" = '' THEN TbSimpro.\"Cd_Simpro\" ELSE TbSimpro.\"Cd_TUSS\" END),
                TbSimpro.\"Cd_Simpro\",
                TbSimpro.\"Ds_Produto\",  
               (CASE WHEN TbFaturamento.\"Tp_TabFat\" = 'SPFB' 
                     then (case when TbSimpro.\"ProdFracao_SN\" = 'S' 
                               THEN TbSimpro.\"Pr_FabFracao\" 
                               else TbSimpro.\"Pr_FabEmbalagem\" 
                          end) 
                     else (case when TbFaturamento.\"Tp_TabFat\" = 'SPMC' 
                               then (case when TbSimpro.\"ProdFracao_SN\" = 'S' 
                                         THEN TbSimpro.\"Pr_VenFracao\" 
                                         else TbSimpro.\"Pr_VenEmbalagem\"
                                     end)
                          end)
                 end),
        TbSimpro.\"Qt_Embalagem\", 
        case when TbSimpro.\"ProdFracao_SN\" = 'S' 
             then TbSimpro.\"Tp_Fracao\" 
             else TbSimpro.\"Tp_Embalagem\" 
        end,
        TbSimpro.\"DT_Vigencia\" , 
        TbSimpro.\"Dt_Ativo\", TbSimpro.\"Tp_Ativo\",
        TbSimpro.\"NumeroMsg\",
        TbFaturamento.\"Id_Faturamento\"";
        $query = $this->db->query($sql);
        $this->db->stop_cache();
        $this->db->flush_cache();
        return $query->result();
    }


function adicionaProFat($info)
    {
        $this->db->reconnect();
        $this->db->start_cache();
        $sql="INSERT INTO \"TbProFat\" (\"Ds_ProFat\", \"Ds_Unidade\", \"TbGrupoPro_CodGrupo\", \"Tp_Ativo\", \"SN_PACOTE\", \"CodProFat\", \"TbUsuEmp_Id_UsuEmp\", \"TbEmpresa_Id_Empresa\")
        VALUES ('{$info['Ds_ProFat']}', '{$info['Ds_Unidade']}', {$info['TbGrupoPro_CodGrupo']}, '{$info['Tp_Ativo']}', '{$info['SN_PACOTE']}', '{$info['CodProFat']}', {$info['TbUsuEmp_Id_UsuEmp']}, {$info['TbEmpresa_Id_Empresa']})";
        $query = $this->db->query($sql);
        
        $this->db->stop_cache();
        $this->db->flush_cache();
        return $query;
    }



 /*   function adicionaProFat($info)
    {
        $this->db->reconnect();
        $this->db->start_cache();
        $sql="INSERT INTO TbProFat (Ds_ProFat, Ds_Unidade, TbGrupoPro_CodGrupo, Tp_Ativo, SN_PACOTE, CodProFat, TbUsuEmp_Id_UsuEmp, TbEmpresa_Id_Empresa)
        VALUES ('{$info['Ds_ProFat']}', '{$info['Ds_Unidade']}', {$info['TbGrupoPro_CodGrupo']}, '{$info['Tp_Ativo']}', '{$info['SN_PACOTE']}', {$info['CodProFat']}, {$info['TbUsuEmp_Id_UsuEmp']}, {$info['TbEmpresa_Id_Empresa']})";
        $query = $this->db->query($sql);
        $this->db->stop_cache();
        $this->db->flush_cache();
        return $query;
    } */

    function apagaProFat()
    {
        $res = $this->db->delete('TbProFat');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function carregaConsolidadoSimproMsgs()
    {
        $this->db->select('Msg.NumeroMsg, Msg.Dt_Criacao, SUM(CASE WHEN "Tp_Alteracao" = \'I\' THEN 1 ELSE 0 END) Inclusoes, SUM(CASE WHEN "Tp_Alteracao"= \'P\' THEN 1 ELSE 0 END) Precos, SUM(CASE WHEN "Tp_Alteracao" = \'A\' THEN 1 ELSE 0 END) Alteracoes, SUM(CASE WHEN "Tp_Alteracao" = \'L\' THEN 1 ELSE 0 END) Fora_Linha, SUM(CASE WHEN "Tp_Alteracao" = \'S\' THEN 1 ELSE 0 END) Atualizacao_Suspensa, SUM(CASE WHEN "Tp_Alteracao" = \'D\' THEN 1 ELSE 0 END) Descontinuados');
        $this->db->from('TbSimproMsg as Msg');
        $this->db->where('Msg.Tp_Ativo', 'S');
        $this->db->group_by('Msg.NumeroMsg') ;
        $this->db->group_by('Msg.Dt_Criacao') ;

        $query = $this->db->get();

        return $query->result();
    }

    function carregaConsolidadoBrasindiceMsgs()
    {
        $this->db->select('Msg.NumeroMsg, Msg.Dt_Criacao, SUM(CASE WHEN "TP_ALT" = \'I\' THEN 1 ELSE 0 END) Inclusoes, SUM(CASE WHEN "TP_ALT" = \'P\' THEN 1 ELSE 0 END) Precos, SUM(CASE WHEN "TP_ALT" = \'A\' THEN 1 ELSE 0 END) Alteracoes, SUM(CASE WHEN "TP_ALT" = \'S\' THEN 1 ELSE 0 END) Atualizacao_Suspensa, SUM(CASE WHEN "TP_ALT" = \'D\' THEN 1 ELSE 0 END) Descontinuados');
        $this->db->from('TbBrasindiceMsg as Msg');
        $this->db->where('Msg.Tp_Ativo', 'S');
        $this->db->group_by('Msg.NumeroMsg') ;
        $this->db->group_by('Msg.Dt_Criacao') ;

        $query = $this->db->get();

        return $query->result();
    }

    function apagaBrasindiceMsg($numeroMsg)
    {
        $this->db->where('NumeroMsg', $numeroMsg);
        $res = $this->db->delete('TbBrasindiceMsg');

        return TRUE;
    }

    function apagaSimproMsg($numeroMsg)
    {
        $this->db->where('NumeroMsg', $numeroMsg);
        $res = $this->db->delete('TbSimproMsg');

        return TRUE;
    }

    function carregaSimproPelaMsg($numeroMsg)
    {
        $this->db->select('Simpro.Cd_Simpro');
        $this->db->from('TbSimpro as Simpro');
        $this->db->where('Simpro.Tp_Ativo', 'S');
        $this->db->where('Simpro.NumeroMsg', $numeroMsg);
        
        $query = $this->db->get();

        return $query->result();
    }


    function carregaInfoSimproMsgs()
    {
        $this->db->select('Msg.NumeroMsg, Msg.Dt_Criacao');
        $this->db->from('TbSimproMsg as Msg');
        $this->db->where('Msg.Tp_Ativo', 'S');
        $this->db->order_by('Msg.Id_Simpro', 'DESC');
        $this->db->limit(1);
        
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoBrasindiceMsgs()
    {
        $this->db->select('Msg.NumeroMsg, Msg.Dt_Criacao');
        $this->db->from('TbBrasindice as Msg');
        $this->db->order_by('Msg.Id_Brasindice ', 'DESC');
        $this->db->limit(1);
        
        $query = $this->db->get();

        return $query->result();
    }


    function verSeExisteCdSimproNaFatItem($CdSimpro,$idFaturamento)
    {
        $this->db->select('FatItem.Id_FatItem');
        $this->db->from('TbFatItem as FatItem');
        $this->db->where('FatItem.Tp_Ativo', 'S');
        $this->db->where('FatItem.Cd_TISS', $CdSimpro);
        $this->db->where('FatItem.TbFaturamento_Id_Faturamento', $idFaturamento);
        
        $query = $this->db->get();

        //var_dump($this->db->last_query());exit;

        return $query->result();
    }


    function backupTbSimpro($idUsuario)
    {
        $query = $this->db->query("SELECT backupSIMPRO({$idUsuario})");
        return TRUE;
    }


    function inclusaoFatItemPelaSimpro($info)
    {
        $this->db->reconnect();
        $this->db->start_cache();
        $sql = "INSERT INTO \"TbFatItem\" (\"TbFaturamento_Id_Faturamento\", \"TbEmpresa_Id_Empresa\", \"Cd_TISS\", \"Cd_TUSS\",
        \"Ds_FatItem\", \"Vl_Total\", \"Qt_Embalagem\", \"Ds_Unidade\", \"Dt_IniVigencia\", \"Dt_Ativo\", \"Tp_Ativo\",
        \"Ds_Motivo_alteracao\")
        VALUES ({$info[0]->TbFaturamento_Id_Faturamento}, {$info[0]->TbEmpresa_Id_Empresa}, '{$info[0]->Cd_TISS}', '{$info[0]->Cd_TUSS}', 
        '{$info[0]->Ds_FatItem}', {$info[0]->Vl_Total}, {$info[0]->Qt_Embalagem}, '{$info[0]->Ds_Unidade}', 
        '{$info[0]->Dt_IniVigencia}', '{$info[0]->Dt_Ativo}', '{$info[0]->Tp_Ativo}', '{$info[0]->Ds_Motivo_alteracao}')";
        $query = $this->db->query($sql);
        $this->db->stop_cache();
        $this->db->flush_cache();
        return $this->db->affected_rows();
    //    return $query;
    }


   /* function inclusaoFatItemPelaSimpro()
    {

        $this->db->reconnect();
        $this->db->start_cache();
        $sql="
        UPDATE \"TbFatItem\" TbFatItem
        SET \"Cd_TUSS\" = (CASE WHEN TbSimpro.\"Cd_TUSS\" = '0' THEN TbSimpro.\"Cd_Simpro\" ELSE TbSimpro.\"Cd_TUSS\" END), 
        \"Ds_FatItem\" = TbSimpro.\"Ds_Produto\", 
        \"Vl_Total\" = (CASE WHEN TbFaturamento.\"Tp_TabFat\" = 'SPFB' AND 
        TbSimpro.\"ProdFracao_SN\" = 'S' THEN TbSimpro.\"Pr_FabFracao\" WHEN TbFaturamento.\"Tp_TabFat\" = 'SPMC' AND 
        TbSimpro.\"ProdFracao_SN\" = 'S' THEN TbSimpro.\"Pr_VenFracao\" ELSE (CASE WHEN TbFaturamento.\"Tp_TabFat\" = 'SPFB' THEN TbSimpro.\"Pr_FabEmbalagem\" WHEN TbFaturamento.\"Tp_TabFat\" = 'SPMC' THEN TbSimpro.\"Pr_VenEmbalagem\" ELSE 1 END) END), 
        \"Qt_Embalagem\" = TbSimpro.\"Qt_Embalagem\", 
        \"Ds_Unidade\" = (CASE WHEN TbSimpro.\"ProdFracao_SN\" = 'S' THEN TbSimpro.\"Tp_Fracao\" ELSE TbSimpro.\"Tp_Embalagem\" END), 
        \"Dt_IniVigencia\" = TbSimpro.\"DT_Vigencia\", 
        \"Dt_Ativo\" = TbSimpro.\"DT_Vigencia\", 
        \"Tp_Ativo\" = 'S', 
        \"Ds_Motivo_alteracao\" = TbSimpro.\"NumeroMsg\"
        FROM \"TbSimpro\" TbSimpro, \"TbFaturamento\" TbFaturamento
        where (TbSimpro.\"Cd_Simpro\" != TbFatItem.\"Cd_TISS\" AND TbSimpro.\"Tp_Alteracao\" = 'I') and
        (TbFaturamento.\"Id_Faturamento\" = TbFatItem.\"TbFaturamento_Id_Faturamento\" AND TbFaturamento.\"Tp_TabFat\" IN ('SPFB','SPMC'));";
        $query = $this->db->query($sql);
        var_dump($this->db->last_query());exit;
        $this->db->stop_cache();
        $this->db->flush_cache();
        return $query;
    } */

    function precoFatItemPelaSimpro($numeroMsg)
    {
        $this->db->reconnect();
        $this->db->start_cache();
        $sql="UPDATE \"TbFatItem\" TbFatItem
        SET  \"Vl_Total\" = (CASE WHEN (Faturamento.\"Tp_TabFat\" = 'SPFB')
                                    THEN CASE WHEN Simpro.\"ProdFracao_SN\" = 'S'
                                                THEN Simpro.\"Pr_FabFracao\" 
                                                ELSE Simpro.\"Pr_FabEmbalagem\" 
                                            END
                                    ELSE CASE WHEN (Faturamento.\"Tp_TabFat\" = 'SPMC') 
                                                THEN CASE WHEN Simpro.\"ProdFracao_SN\" = 'S'
                                                        THEN Simpro.\"Pr_VenFracao\" 
                                                        ELSE Simpro.\"Pr_VenEmbalagem\" 
                                                    END 
                                            END
                                END ),
            \"Qt_Embalagem\" = Simpro.\"Qt_Embalagem\",
            \"Ds_Unidade\" = (CASE WHEN Simpro.\"ProdFracao_SN\" = 'S' THEN Simpro.\"Tp_Fracao\" ELSE Simpro.\"Tp_Embalagem\" END),
            \"Dt_IniVigencia\" = Simpro.\"DT_Vigencia\",
            \"Dt_Ativo\" = Simpro.\"DT_Vigencia\",
            -- \"Dt_Atualizacao\" = NOW(),
            \"Tp_Ativo\" = 'S',
            \"Ds_Motivo_alteracao\" = Simpro.\"NumeroMsg\",
            \"Cd_TUSS\"  = (CASE WHEN (Simpro.\"Cd_TUSS\" is null OR Simpro.\"Cd_TUSS\" = '') 
                                       THEN Simpro.\"Cd_Simpro\" 
                                       ELSE Simpro.\"Cd_TUSS\" END)
        FROM 
        \"TbSimpro\" Simpro,
        \"TbFaturamento\" Faturamento
        where
        Simpro.\"NumeroMsg\" = '{$numeroMsg}' AND
        (Simpro.\"Cd_Simpro\" = TbFatItem.\"Cd_TISS\" AND Simpro.\"Tp_Alteracao\" = 'P')
        and (Faturamento.\"Id_Faturamento\" = TbFatItem.\"TbFaturamento_Id_Faturamento\"  AND Faturamento.\"Tp_TabFat\" IN ('SPFB','SPMC'))";
        $query = $this->db->query($sql);
        $this->db->stop_cache();
        $this->db->flush_cache();
        return $this->db->affected_rows();
    }

    function alteracoesFatItemPelaSimpro($numeroMsg)
    {
        $this->db->reconnect();
        $this->db->start_cache();
        $sql="UPDATE \"TbFatItem\" FatItem
        SET  \"Cd_TUSS\"  = (CASE WHEN (Simpro.\"Cd_TUSS\" is null OR Simpro.\"Cd_TUSS\" = '') 
                                       THEN Simpro.\"Cd_Simpro\" 
                                       ELSE Simpro.\"Cd_TUSS\" END),
             \"Ds_FatItem\" = Simpro.\"Ds_Produto\",
             \"Vl_Total\" = ( CASE WHEN (Faturamento.\"Tp_TabFat\" = 'SPFB')
                                         THEN CASE WHEN  Simpro.\"ProdFracao_SN\" = 'S'
                                                   THEN Simpro.\"Pr_FabFracao\" 
                                                   ELSE Simpro.\"Pr_FabEmbalagem\" 
                                              END
                                         ELSE CASE WHEN (Faturamento.\"Tp_TabFat\" = 'SPMC') 
                                                   THEN CASE WHEN Simpro.\"ProdFracao_SN\" = 'S'
                                                             THEN Simpro.\"Pr_VenFracao\" 
                                                             ELSE Simpro.\"Pr_VenEmbalagem\" 
                                                        END 
                                               END
                                         END  ),        
             \"Qt_Embalagem\" = Simpro.\"Qt_Embalagem\",
             \"Ds_Unidade\" = (CASE 
                WHEN Simpro.\"ProdFracao_SN\" = 'S' THEN Simpro.\"Tp_Fracao\"
                ELSE Simpro.\"Tp_Embalagem\" END),
             \"Dt_Atualizacao\" = NOW(),
             \"Tp_Ativo\" = 'S',
             \"Ds_Motivo_alteracao\" = Simpro.\"NumeroMsg\"
        FROM 
        \"TbSimpro\" Simpro,
        \"TbFaturamento\" Faturamento
        where
        Simpro.\"NumeroMsg\" = '{$numeroMsg}' AND
        (Simpro.\"Cd_Simpro\" = FatItem.\"Cd_TISS\" AND Simpro.\"Tp_Alteracao\" = 'A')
        and (Faturamento.\"Id_Faturamento\" = FatItem.\"TbFaturamento_Id_Faturamento\" AND Faturamento.\"Tp_TabFat\" IN ('SPFB','SPMC'));";
        $query = $this->db->query($sql);
        $this->db->stop_cache();
        $this->db->flush_cache();
        return $this->db->affected_rows();
    }

    function foradeLinhaFatItemPelaSimpro($numeroMsg)
    {
        $this->db->reconnect();
        $this->db->start_cache();
        $sql="UPDATE \"TbFatItem\" FatItem
        SET  \"Dt_FimVigencia\" = Simpro.\"Dt_Atualizacao\",
              \"Dt_Inativo\" = Simpro.\"Dt_Atualizacao\",
              \"Ds_Motivo_alteracao\" = CONCAT((CASE WHEN Simpro.\"Tp_Alteracao\" = 'L' 
                                                        THEN 'Item fora de linha na mensagem'
                                                   else case WHEN Simpro.\"Tp_Alteracao\" = 'D' 
                                                             THEN 'Item descontinuado na mensagem' 
                                                             else case WHEN Simpro.\"Tp_Alteracao\" = 'S' 
                                                                       THEN 'Item suspenso na mensagem' 
                                                                  end
                                                         end end), ' - ', Simpro.\"NumeroMsg\")
        from 
        \"TbSimpro\" Simpro,
        \"TbFaturamento\" Faturamento
        where
        Simpro.\"NumeroMsg\" = '{$numeroMsg}' AND
        (Simpro.\"Cd_Simpro\" = FatItem.\"Cd_TISS\" AND (Simpro.\"Tp_Alteracao\" = 'L' OR Simpro.\"Tp_Alteracao\" = 'D' OR Simpro.\"Tp_Alteracao\" = 'S'))
         and (Faturamento.\"Id_Faturamento\" = FatItem.\"TbFaturamento_Id_Faturamento\" AND Faturamento.\"Tp_TabFat\" IN ('SPFB','SPMC'));";
        $query = $this->db->query($sql);
        $this->db->stop_cache();
        $this->db->flush_cache();
        return $this->db->affected_rows();
    } 

    function atualizaPrecoSimproMae($info)
    {
    $this->db->reconnect();
    $this->db->start_cache();

    //$cdSimpro = ltrim($info['Cd_Simpro'], "0");
    $cdSimpro = $info['Cd_Simpro'];

    $sql="
    UPDATE \"TbSimpro\" Simpro
    SET \"NumeroMsg\" = '{$info['NumeroMsg']}',
    \"Pr_FabEmbalagem\"	= {$info['Pr_FabEmbalagem']},
    \"Pr_VenEmbalagem\" = {$info['Pr_VenEmbalagem']},
    \"Pr_UsuEmbalagem\" = {$info['Pr_UsuEmbalagem']},
    \"Pr_FabFracao\" = {$info['Pr_FabFracao']},
    \"Pr_VenFracao\" = {$info['Pr_VenFracao']},
    \"Tp_Alteracao\" = '{$info['Tp_Alteracao']}',
    \"Cd_TUSS\" = '{$info['Cd_TUSS']}',
    \"Dt_Atualizacao\" = NOW()
    WHERE Simpro.\"Cd_Simpro\" = '{$cdSimpro}'";

    $query = $this->db->query($sql);
    $this->db->stop_cache();
    $this->db->flush_cache();
    return $query;
    }

    function atualizaLinhaSimproMae($info)
    {
        //$cdSimpro = ltrim($info['Cd_Simpro'], "0");
        $cdSimpro = $info['Cd_Simpro'];

        $this->db->where('Cd_Simpro', $cdSimpro);
        $this->db->update('TbSimpro', $info);
        
        return TRUE;
    }

    function atualizaTipAltSimproMae($info)
    {

    //$cdSimpro = ltrim($info['Cd_Simpro'], "0");
    $cdSimpro = $info['Cd_Simpro'];

    $this->db->reconnect();
    $this->db->start_cache();
    $sql="
    UPDATE \"TbSimpro\" Simpro
    SET \"Tp_Alteracao\" = '{$info['Tp_Alteracao']}',
    \"NumeroMsg\" = '{$info['NumeroMsg']}',
    \"Dt_Atualizacao\" = NOW()
    WHERE Simpro.\"Cd_Simpro\" = '{$cdSimpro}'";
    $query = $this->db->query($sql);

    $this->db->stop_cache();
    $this->db->flush_cache();
    return $query;
    }


    function carregaInfoTUSS($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbTUSS as TUSS');
        $this->db->where('TUSS.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('TUSS.Deletado !=', 'S');
        $this->db->where('TUSS.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaTUSS($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('TbTUSS', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }

    function carregaInfoRegraGruPro($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Tb_RegraGruPro as RegraGruPro');
        $this->db->where('RegraGruPro.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('RegraGruPro.Deletado !=', 'S');
        $this->db->where('RegraGruPro.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaRegraGruPro($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('Tb_RegraGruPro', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }

    function carregaInfoFracaoSimproBra($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Tb_FracaoSimproBra as FracaoSimproBra');
        $this->db->where('FracaoSimproBra.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('FracaoSimproBra.Deletado !=', 'S');
        $this->db->where('FracaoSimproBra.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaFracaoSimproBra($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('Tb_FracaoSimproBra', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }

    function carregaInfoProduto($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Tb_Produto as Produto');
        $this->db->where('Produto.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('Produto.Deletado !=', 'S');
        $this->db->where('Produto.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaProduto($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('Tb_Produto', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }

    function carregaInfoProducao($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Tb_Producao as Producao');
        $this->db->where('Producao.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('Producao.Deletado !=', 'S');
        $this->db->where('Producao.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaProducao($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('Tb_Producao', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }

    function carregaInfoContrato($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbContrato as Contrato');
        $this->db->where('Contrato.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('Contrato.Deletado !=', 'S');
        $this->db->where('Contrato.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaContrato($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('TbContrato', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }

    function adicionaItensEmpacotados($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('tb_itens_empacotados', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }

    function carregaInfoPorteMedico($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbPorteMedico as PorteMedico');
        $this->db->where('PorteMedico.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('PorteMedico.Deletado !=', 'S');
        $this->db->where('PorteMedico.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaPorteMedico($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('TbPorteMedico', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }

    function carregaInfoExcecaoValores($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbExcValores as ExcValores');
        $this->db->where('ExcValores.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('ExcValores.Deletado !=', 'S');
        $this->db->where('ExcValores.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaExcecaoValores($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('TbExcValores', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }


    function carregaInfoFatItem($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbFatItem as FatItem');
        $this->db->where('FatItem.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('FatItem.Deletado !=', 'S');
        $this->db->where('FatItem.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaFatItem($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('TbFatItem', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }


    function verificaExisteSimpro($cdSimpro)
    {
        $this->db->select('*');
        $this->db->from('TbSimpro as Simpro');
        $this->db->where('Simpro.Cd_Simpro', $cdSimpro);
        $this->db->where('Simpro.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoFaturamento($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbFaturamento as Faturamento');
        $this->db->where('Faturamento.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->where('Faturamento.Tp_Ativo', 'S');
        $this->db->order_by('Faturamento.Id_Faturamento', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoFaturamentoAtualizarFatItem()
    {
        $this->db->select('*');
        $this->db->from('TbFaturamento as Faturamento');
    //    $this->db->where('Faturamento.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->where('Faturamento.Tp_Ativo', 'S');
        $inCriteria = "(Faturamento.Tp_TabFat IN ('SPFB','SPMC'))";
        $this->db->where($inCriteria);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoDePara($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Rl_DeparaImportacao as DePara');
        $this->db->where('DePara.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('DePara.Deletado !=', 'S');
        $this->db->where('DePara.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaDePara($idLayout, $noImportacao, $idEmpresa)
    {
        $idEmpresa = 13; //TIRAR ISSO QUANDO COLOCAR POR GRUPO

        $this->db->select('*');
        $this->db->from('Rl_DeparaImportacao as DePara');
        $this->db->where('DePara.No_Importacao', $noImportacao);
        $this->db->where('DePara.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->where('DePara.Tb_Id_LayoutImportacao', $idLayout);
    //    $this->db->where('DePara.Deletado !=', 'S');
        $this->db->where('DePara.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function listaDePara($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('LayoutImportacao.Ds_LayoutImportacao, DePara.*');
        $this->db->from('Rl_DeparaImportacao as DePara');
        $this->db->join('Tb_LayoutImportacao as LayoutImportacao', 'LayoutImportacao.Id_LayoutImportacao = DePara.Tb_Id_LayoutImportacao','left');
    //     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(DePara.No_Importacao LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

    //    $this->db->where('DePara.Deletado !=', 'S');
        $this->db->where('DePara.TbEmpresa_Id_Empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function adicionaDePara($info)
    {
        $this->db->trans_start();
        $this->db->insert('Rl_DeparaImportacao', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function editaDePara($info, $id)
    {
        $this->db->where('Id_DeparaImportacao ', $id);
        $this->db->update('Rl_DeparaImportacao', $info);

        return TRUE;
    }

    function apagaDePara($id)
    {
        $this->db->where('Id_DeparaImportacao', $id);
        $res = $this->db->delete('Rl_DeparaImportacao');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function consultaNoImportacao($Tb_Id_LayoutImportacao,$idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Tb_LayoutImportacao as LayoutImportacao');
        $this->db->where('LayoutImportacao.Id_LayoutImportacao', $Tb_Id_LayoutImportacao);
        $this->db->where('LayoutImportacao.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('LayoutImportacao.Deletado !=', 'S');
        $this->db->where('LayoutImportacao.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoDeParaEmpresa($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Rl_DeparaImportacao as DePara');
        $this->db->where('DePara.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('DePara.Deletado !=', 'S');
        $this->db->where('DePara.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoDeParaId($Id)
    {
        $this->db->select('*');
        $this->db->from('Rl_DeparaImportacao');
        $this->db->where('Id_DeparaImportacao', $Id);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoLayoutImportacaoEmpresa($noImportacao,$idEmpresa)
    {
        $idEmpresa = 13; //TIRAR ISSO QUANDO COLOCAR POR GRUPO
        $this->db->select('*');
        $this->db->from('Tb_LayoutImportacao as LayoutImportacao');
        if ($noImportacao != 'todos') {
        $this->db->where('LayoutImportacao.No_Importacao', $noImportacao);
        }
        $this->db->where('LayoutImportacao.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('LayoutImportacao.Deletado !=', 'S');
        $this->db->where('LayoutImportacao.Tp_Ativo', 'S');
        $this->db->order_by('LayoutImportacao.Id_LayoutImportacao', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function listaLayoutImportacao($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('LayoutImportacao.*');
        $this->db->from('Tb_LayoutImportacao as LayoutImportacao');
    //     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(LayoutImportacao.Ds_LayoutImportacao LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

    //    $this->db->where('LayoutImportacao.Deletado !=', 'S');
        $this->db->where('LayoutImportacao.TbEmpresa_Id_Empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function carregaInfoLayoutImportacao($Id)
    {
        $this->db->select('*');
        $this->db->from('Tb_LayoutImportacao');
        $this->db->where('Id_LayoutImportacao', $Id);
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaLayoutImportacao($info)
    {
        $this->db->trans_start();
        $this->db->insert('Tb_LayoutImportacao', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function editaLayoutImportacao($info, $id)
    {
        $this->db->where('Id_LayoutImportacao ', $id);
        $this->db->update('Tb_LayoutImportacao', $info);

        return TRUE;
    }

    function apagaLayoutImportacao($id)
    {
        $this->db->where('Id_LayoutImportacao', $id);
        $res = $this->db->delete('Tb_LayoutImportacao');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function consultaCamposTabela($DsTabela)
    {
        $this->db->select('column_name as Ds_CampoDestino');
        $this->db->from('information_schema.columns');
        $this->db->where('table_name', $DsTabela);
        $this->db->order_by('column_name', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function apagaImportacaoGrupoPro($id)
    {
        $this->db->where('CodGrupoPro', $id);
        $res = $this->db->delete('TbGrupoPro');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }
    }

    function apagaImportacaoFatItem($id)
    {
        $this->db->where('Id_FatItem', $id);
        $res = $this->db->delete('TbFatItem');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function apagaImportacaoProFat($id)
    {
        $this->db->where('Cd_ProFat', $id);
        $res = $this->db->delete('TbProFat');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function apagaImportacaoTUSS($id)
    {
        $this->db->where('Id_Tuss', $id);
        $res = $this->db->delete('TbTUSS');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function apagaImportacaoRegraGruPro($id)
    {
        $this->db->where('Id_RegraGruPro', $id);
        $res = $this->db->delete('Tb_RegraGruPro');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function apagaImportacaoFracaoSimproBra($id)
    {
        $this->db->where('Id_FracaoSimproBra', $id);
        $res = $this->db->delete('Tb_FracaoSimproBra');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function apagaImportacaoProduto($id)
    {
        $this->db->where('Id_Produto', $id);
        $res = $this->db->delete('Tb_Produto');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function apagaImportacaoProducao($id)
    {
        $this->db->where('Id_Producao', $id);
        $res = $this->db->delete('Tb_Producao');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function apagaImportacaoPorteMedico($id)
    {
        $this->db->where('Id_PorteMedico', $id);
        $res = $this->db->delete('TbPorteMedico');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function apagaImportacaoExcecaoValores($id)
    {
        $this->db->where('Id_ExcValores', $id);
        $res = $this->db->delete('TbExcValores');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function consultaRegraTbFatItemExistente($Cd_TUSS, $Cd_TISS, $TbFaturamento_Id_Faturamento, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbFatItem as FatItem');
        $this->db->where('FatItem.Cd_TUSS', $Cd_TUSS);
        $this->db->where('FatItem.Cd_TISS', $Cd_TISS);
        $this->db->where('FatItem.TbFaturamento_Id_Faturamento', $TbFaturamento_Id_Faturamento);
        $this->db->where('FatItem.TbEmpresa_Id_Empresa', $IdEmpresa);
    //    $this->db->where('FatItem.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaRegraTbGrupoProExistente($CodGrupoPro, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbGrupoPro as GrupoPro');
        $this->db->where('GrupoPro.CodGrupoPro', $CodGrupoPro);
        $this->db->where('GrupoPro.TbEmpresa_Id_Empresa', $IdEmpresa);
    //    $this->db->where('GrupoPro.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaCdSimproTbSimproExistente($CdSimpro)
    {
        $this->db->select('*');
        $this->db->from('TbSimpro as Simpro');
        $this->db->where('Simpro.Cd_Simpro', $CdSimpro);
        $query = $this->db->get();

        return $query->result();
    }

    function consultaRegraTbProFatExistente($CodProFat, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbProFat as ProFat');
        $this->db->where('ProFat.CodProFat', $CodProFat);
        $this->db->where('ProFat.TbEmpresa_Id_Empresa', $IdEmpresa);
      // $this->db->where('ProFat.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaRegraTbTUSSExistente($TbProFat_Cd_ProFat, $TbConvenio_Id_Convenio, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbTUSS as TUSS');
        $this->db->where('TUSS.TbProFat_Cd_ProFat', $TbProFat_Cd_ProFat);
        $this->db->where('TUSS.TbConvenio_Id_Convenio', $TbConvenio_Id_Convenio);
        $this->db->where('TUSS.TbEmpresa_Id_Empresa', $IdEmpresa);
    //    $this->db->where('TUSS.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaRegraTbExcValoresExistente($Cd_TUSS, $Cd_ProFat, $CD_Convenio, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbExcValores as ExcValores');
        $this->db->where('ExcValores.Cd_TUSS', $Cd_TUSS);
        $this->db->where('ExcValores.Cd_ProFat', $Cd_ProFat);
        $this->db->where('ExcValores.CD_Convenio', $CD_Convenio);
        $this->db->where('ExcValores.TbEmpresa_Id_Empresa', $IdEmpresa);
    //    $this->db->where('ExcValores.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaRegraTbProdutoExistente($Cd_Produto, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Tb_Produto as Produto');
        $this->db->where('Produto.Cd_Produto', $Cd_Produto);
        $this->db->where('Produto.TbEmpresa_Id_Empresa', $IdEmpresa);
    //    $this->db->where('Produto.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaRegraTbFracaoSimproBraExistente($CDTISS, $TbFatitem_Id_Fatitem, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Tb_FracaoSimproBra as FracaoSimproBra');
        $this->db->where('FracaoSimproBra.CD_TISS', $CDTISS);
        $this->db->where('FracaoSimproBra.TbFatItem_Id_FatItem', $TbFatitem_Id_Fatitem);
        $this->db->where('FracaoSimproBra.TbEmpresa_Id_Empresa', $IdEmpresa);
    //    $this->db->where('Produto.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }
    
    function consultaRegraTbProducaoExistente($TbProFat_Cd_ProFat, $Dt_Lancamento, $TbPlano_Id_Plano, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Tb_Producao as Producao');
        $this->db->where('Producao.TbProFat_Cd_ProFat', $TbProFat_Cd_ProFat);
        $this->db->where('Producao.Dt_Lancamento', $Dt_Lancamento);
        $this->db->where('Producao.TbPlano_Id_Plano', $TbPlano_Id_Plano);
        $this->db->where('Producao.TbEmpresa_Id_Empresa', $IdEmpresa);
    //    $this->db->where('Producao.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }


    function consultaIdEmpresaPorERP($ERPEmpresa)
    {
        $this->db->select('Empresa.Id_Empresa');
        $this->db->from('TbEmpresa as Empresa');
        $this->db->where('Empresa.Cd_EmpresaERP', $ERPEmpresa);
    //    $this->db->where('Empresa.Deletado !=', 'S');
        $this->db->where('Empresa.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function verificaBrasindiceCondInclusao($CdTISS, $TpPreco)
    {
        $this->db->select('*');
        $this->db->from('TbBrasindice as Brasindice');
        $this->db->where('Brasindice.Cd_TISS', $CdTISS);
        $this->db->where('Brasindice.Tp_Preco', $TpPreco);
    //    $this->db->where('Empresa.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function verificaBrasindiceCondAltPreco($CdTISS, $TpPreco, $numeroMsg)
    {
        $this->db->select('*');
        $this->db->from('TbBrasindice as Brasindice');
        $this->db->where('Brasindice.Cd_TISS', $CdTISS);
        $this->db->where('Brasindice.Tp_Preco', $TpPreco);
        $this->db->where('Brasindice.NumeroMsg !=', $numeroMsg);
    //    $this->db->where('Empresa.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function verificaBrasindiceCondAltTUSS($CdTISS, $TpPreco, $numeroMsg, $CdTUSS)
    {
        $this->db->select('*');
        $this->db->from('TbBrasindice as Brasindice');
        $this->db->where('Brasindice.Cd_TISS', $CdTISS);
        $this->db->where('Brasindice.Tp_Preco', $TpPreco);
        $this->db->where('Brasindice.NumeroMsg', $numeroMsg);
        $this->db->where('Brasindice.Cd_TUSS !=', $CdTUSS);
    //    $this->db->where('Empresa.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function verificaBrasindiceCondExclusao($CdTISS, $TpPreco, $numeroMsg)
    {
        $this->db->select('*');
        $this->db->from('TbBrasindice as Brasindice');
        $this->db->where('Brasindice.Cd_TISS', $CdTISS);
        $this->db->where('Brasindice.Tp_Preco', $TpPreco);
        $this->db->where('Brasindice.NumeroMsg', $numeroMsg);
    //    $this->db->where('Empresa.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaRegraTbProFatCdGrupoProExistente($CodProFat, $IdEmpresa, $CodGrupoPro)
    {
        $this->db->select('*');
        $this->db->from('TbProFat as ProFat');
        $this->db->where('ProFat.CodProFat', $CodProFat);
        $this->db->where('ProFat.TbEmpresa_Id_Empresa', $IdEmpresa);
        $this->db->where('ProFat.TbGrupoPro_CodGrupo', $CodGrupoPro);
        $query = $this->db->get();

        return $query->result();
    }

    function atualizaProFat($info)
    {
        $CodProFat = $info['CodProFat'];
        $idEmpresa = $info['TbEmpresa_Id_Empresa'];

        $this->db->where('CodProFat', $CodProFat);
        $this->db->where('TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->update('TbProFat', $info);
        
        return TRUE;
    }

    function carregaInfoNotificacaoCarga()
    {
        $this->db->select('*');
        $this->db->from('tb_notificacao_carga');
        $this->db->where('st_acessado', 'nao');
        $this->db->where('status', 'sucesso');
        $query = $this->db->get();

        return $query->result();
    }


    function limpaNotificacaoCarga($info)
    {
        $idNotificacaoCarga = $info['id_notificacao_carga'];

        $this->db->where('id_notificacao_carga', $idNotificacaoCarga);
        $this->db->update('tb_notificacao_carga', $info);
        
        return TRUE;
    }

    function adicionaTabelaDepara($info,$noTabela)
    {
        $this->db->trans_start();
        $insert = $this->db->insert($noTabela, $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }

    function adicionaAnaliseBI($info)
    {
        $this->db->trans_start();
        $insert = $this->db->insert('tb_analisebi', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert;
    }

}

  