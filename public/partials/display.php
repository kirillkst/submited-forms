<?php
/**
 * @since      1.0.0
 *
 * @package    Submited_Forms
 * @subpackage Submited_Forms/public/partials
 */
?>
<table class="scroll-table fs-14">
	<thead>
		<tr>
			<th>№</th>
			<th>Время</th>
			<th>Тема</th>
			<th style="width:40%">Данные</th>
			<th style="width:30%">Комментарий</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $item) : ?>
			<tr style="vertical-align:top">
				<td><?php echo $item['id'];?></td>
				<td><?php echo date_i18n( 'd.m.Y H:i:s', strtotime( $item['date'] ) ); ?></td>
				<td><?php echo $item['subject'];?></td>
				<td>
					<strong>Имя:</strong> <?php echo $item['name'];?><br><br>
					<strong>Телефон:</strong> <?php echo $item['phone'];?><br><br>
					<strong>E-mail:</strong> <?php echo $item['email'];?><br><br>
					<strong>Сообщение:</strong> <?php echo $item['message'];?><br><br>
					<strong>Страница отправки:</strong> <?php echo $item['page_name'];?><br> <?php echo $item['referer'];?>
					<?php if ($item['data']) echo '<br><br>'.nl2br( $item['additional_data'] );?>
				</td>
				<td><?php echo nl2br( $item['comment'] );?></td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>
