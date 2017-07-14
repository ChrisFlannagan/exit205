<select name="<?php echo $name; ?>">
	<?php 
	
	foreach(FLBuilderPhoto::sizes() as $size => $atts) :
			
			$label = ucwords(str_replace(array('_', '-'), ' ', $size)) . ' (' . implode('x', $atts) . ')';
					
	?>
	<option value="<?php echo $size; ?>" <?php selected($value, $size); ?>><?php echo $label; ?></option>
	<?php endforeach; ?>
	<option value="full" <?php selected( $value, 'full' ); ?>><?php _e( 'Full Size', 'fl-builder' ); ?></option>
</select>