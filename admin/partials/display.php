<?php
/*
 * @since      1.0.0
 *
 * @package    Submited_Forms
 * @subpackage Submited_Forms/admin/partials
 */
?>

<div class="col-sm-12">
	<h1>Формы</h1>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>№</th>
				<th>Время</th>
				<th>Тема</th>	
				<th style="width:40%">Данные</th>			
				<th style="width:40%">Комментарий</th>			
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data as $item) : ?>
				<tr id="form-row-<?php echo $item['id']; ?>">
					<td><?php echo $item['id']; ?></td>
					<td><?php echo date_i18n( 'd.m.Y H:i:s', strtotime( $item['date'] ) ); ?></td>
					<td><?php echo $item['subject'];?></td>	
					<td>
						<strong>Имя:</strong> <?php echo $item['name'];?><br><br>					
						<strong>Телефон:</strong> <?php echo $item['phone'];?><br><br>			
						<strong>E-mail:</strong> <?php echo $item['email'];?><br><br>			
						<strong>Сообщение:</strong> <?php echo $item['message'];?><br><br>	
						<strong>Страница отправки:</strong> <?php echo $item['page_name'];?><br> <?php echo $item['referer'];?>
						<?php if ($item['data']) echo '<br><br>'.nl2br($item['additional_data']);?>
					</td>	
					<td>
						<form action="#" method="post" class="add-comment-form" data-id="<?php echo $item['id']; ?>">
							<textarea name="comment" style="width:100%;height:150px;"><?php echo $item['comment']; ?></textarea>
							<button type="submit" class="btn btn-primary">Обновить</button>
						</form>
					</td>						
					<td align="center" style="text-align:center"><a title="удалить" class="remove-form-row close" href="#" data-id="<?php echo $item['id']; ?>" style="float:none">&times;</a></td>							
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>		
</div>
<script>	
	jQuery(function(){			
		jQuery('.remove-form-row').on('click', function(e){	
			e.preventDefault();	
			var confirmDelete = confirm("Вы действительно хотите удалить эту строку? Удаление безвозвратно.");	
			if(confirmDelete){	
				var id = jQuery(this).data('id');	
				jQuery.ajax({
					type: 'POST',
	                url: '/wp-admin/admin-ajax.php',
	                cache: false,
	                dataType: 'json',
	                data: 'action=submited_forms_delete_row&id=' + id + '&_wpnonce=<?php echo wp_create_nonce('submited_forms_delete_row');?>',							
				}).done(function( html ) {	
					jQuery('#form-row-' + id).fadeOut(function(){
						jQuery(this).remove();
					});	
				}).fail(function() {	
					alert('Oшибка! Обновите страницу и повторите попытку');	
				});
			}			
            return false;
		});	
			
		jQuery(".add-comment-form").submit(function(e) {
	        e.preventDefault();
			var form = jQuery(this);
			var id = form.data('id');
			var data = form.serialize();
			jQuery.ajax({
				type: 'POST',
				url: '/wp-admin/admin-ajax.php',
				cache: false,
				dataType: 'json',
				data: 'action=submited_forms_add_comment&id=' + id + '&' + data + '&_wpnonce=<?php echo wp_create_nonce('submited_forms_add_comment');?>',
				beforeSend: function() {
				  form.find('textarea').css('background', '#ccc');	
			   },						
			}).done(function( html ) {
				form.find('textarea').css('background', '#b9ecb9');	
			}).fail(function() {	
				alert('Oшибка! Обновите страницу и повторите попытку');	
			}).always(function() {				
 			   setTimeout(function() {form.find('textarea').css('background', '#fff');	}, 1000);	
			});				
            return false;
	    });				
	});
</script>  