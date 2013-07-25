<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_total; ?></td>
            <td><input type="text" name="cielo_total" value="<?php echo $cielo_total; ?>" /></td>
          </tr> 
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_afiliacao; ?></td>
            <td><input type="text" name="cielo_afiliacao" value="<?php echo $cielo_afiliacao; ?>" />
              <?php if ($error_afiliacao) { ?>
              <span class="error"><?php echo $error_afiliacao; ?></span>
              <?php } ?>
			</td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_chave; ?></td>
            <td><input style="width:500px" type="text" name="cielo_chave" value="<?php echo $cielo_chave; ?>" />
              <?php if ($error_chave) { ?>
              <span class="error"><?php echo $error_chave; ?></span>
              <?php } ?>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_teste; ?></td>
            <td><select name="cielo_teste">
                <?php if ($cielo_teste) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else if (!$cielo_teste) { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } ?>
                </select>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_cartao_visa; ?></td>
            <td><select name="cielo_cartao_visa">
                <?php if ($cielo_cartao_visa) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else if (!$cielo_cartao_visa) { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } ?>
                </select>
                &nbsp;<?php echo $entry_parcelas;?><input style="width:20px" type="text" name="cielo_visa_parcelas" value="<?php echo $cielo_visa_parcelas; ?>" />
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_cartao_visae; ?></td>
            <td><select name="entry_cartao_visae">
                <?php if ($entry_cartao_visae) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else if (!$entry_cartao_visae) { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } ?>
                </select>
                &nbsp;<?php echo $entry_parcelas;?><input style="width:20px" type="text" name="cielo_visae_parcelas" value="<?php echo $cielo_visae_parcelas; ?>" />
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_cartao_mastercard; ?></td>
            <td><select name="cielo_cartao_mastercard">
                <?php if ($cielo_cartao_mastercard) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else if (!$cielo_cartao_mastercard) { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } ?>
                </select>
                &nbsp;<?php echo $entry_parcelas;?><input style="width:20px" type="text" name="cielo_mastercard_parcelas" value="<?php echo $cielo_mastercard_parcelas; ?>" />
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_cartao_diners; ?></td>
            <td><select name="cielo_cartao_diners">
                <?php if ($cielo_cartao_diners) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else if (!$cielo_cartao_diners) { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } ?>
                </select>
                &nbsp;<?php echo $entry_parcelas;?><input style="width:20px" type="text" name="cielo_diners_parcelas" value="<?php echo $cielo_diners_parcelas; ?>" />
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_cartao_discover; ?></td>
            <td><select name="cielo_cartao_discover">
                <?php if ($cielo_cartao_discover) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else if (!$cielo_cartao_discover) { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } ?>
                </select>
                &nbsp;<?php echo $entry_parcelas;?><input style="width:20px" type="text" name="cielo_discover_parcelas" value="<?php echo $cielo_discover_parcelas; ?>" />
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_cartao_elo; ?></td>
            <td><select name="cielo_cartao_elo">
                <?php if ($cielo_cartao_elo) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else if (!$cielo_cartao_elo) { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } ?>
                </select>
                &nbsp;<?php echo $entry_parcelas;?><input style="width:20px" type="text" name="cielo_elo_parcelas" value="<?php echo $cielo_elo_parcelas; ?>" />
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_cartao_amex; ?></td>
            <td><select name="cielo_cartao_amex">
                <?php if ($cielo_cartao_amex) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else if (!$cielo_cartao_amex) { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } ?>
                </select>
                &nbsp;<?php echo $entry_parcelas;?><input style="width:20px" type="text" name="cielo_amex_parcelas" value="<?php echo $cielo_amex_parcelas; ?>" />
			</td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_cartao_semjuros;?></td>
            <td><input style="width:20px" type="text" name="cielo_cartao_semjuros" value="<?php echo $cielo_cartao_semjuros; ?>" />
              <?php if ($error_cartao_semjuros) { ?>
              <span class="error"><?php echo $error_cartao_semjuros; ?></span>
              <?php } ?>
			</td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_cartao_minimo;?></td>
            <td><input style="width:100px" type="text" name="cielo_cartao_minimo" value="<?php echo $cielo_cartao_minimo; ?>" />
              <?php if ($error_cartao_minimo) { ?>
              <span class="error"><?php echo $error_cartao_minimo; ?></span>
              <?php } ?>
			</td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_cartao_juros;?></td>
            <td><input style="width:20px" type="text" name="cielo_cartao_juros" value="<?php echo $cielo_cartao_juros; ?>" />
              <?php if ($error_cartao_juros) { ?>
              <span class="error"><?php echo $error_cartao_juros; ?></span>
              <?php } ?>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_parcelamento; ?></td>
            <td><select name="cielo_parcelamento">
                <?php if ($cielo_parcelamento == '2') { ?>
                <option value="2" selected="selected"><?php echo $text_loja; ?></option>
                <option value="3"><?php echo $text_administradora; ?></option>
                <?php } else if ($cielo_parcelamento == '3') { ?>
                <option value="2"><?php echo $text_loja; ?></option>
                <option value="3" selected="selected"><?php echo $text_administradora; ?></option>
                <?php } else { ?>
                <option value="2" selected="selected"><?php echo $text_loja; ?></option>
                <option value="3"><?php echo $text_administradora; ?></option>
                <?php } ?>
                </select>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_aprovado; ?></td>
            <td><select name="cielo_aprovado_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $cielo_aprovado_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_nao_aprovado; ?></td>
            <td><select name="cielo_nao_aprovado_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $cielo_nao_aprovado_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="cielo_geo_zone_id">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $cielo_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="cielo_status">
                <?php if ($cielo_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="cielo_sort_order" value="<?php echo $cielo_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 