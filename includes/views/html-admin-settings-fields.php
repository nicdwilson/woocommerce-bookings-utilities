<?php


if ( 'text' === $field['type'] ) { ?>


    <input
            id="<?php echo esc_attr( $field['name'] ); ?>"
            type="<?php echo esc_attr( $field['type'] ); ?>"
            name="<?php echo esc_attr( $field['name'] ); ?>"
            value="<?php echo esc_attr( $field['value'] ); ?>"
            style="<?php echo ( empty( $field['style'] ) ) ? '' : esc_attr( $field['style'] ); ?>"
		<?php echo ( isset( $field['min'] ) ) ? ' min = "' . esc_attr( $field['min'] ) . '"' : ''; ?>
		<?php echo ( isset( $field['max'] ) ) ? ' max = "' . esc_attr( $field['max'] ) . '"' : ''; ?>
		<?php echo ( 'readonly' === $field['type'] ) ? 'readonly' : ''; ?>
    />


	<?php
	if ( isset( $field['helper'] ) ) {
		echo '<span class="helper">' . esc_html( $field['helper'] ) . '</span>';
	}
	if ( isset( $field['description'] ) ) {
		echo '<p class="description">' . esc_html( $field['description'] ) . '</p>';
	}
}


if ( 'checkbox' === $field['type'] ) {

	echo '<input type="checkbox" name="' . esc_attr( $field['name'] ) . '" value="true" ' . esc_attr( checked( $field['value'], 'true', 0 ) ) . ' />';

	if ( isset( $field['helper'] ) ) {
		echo '<span class="helper">' . esc_html( $field['helper'] ) . '</span>';
	}
	if ( isset( $field['description'] ) ) {
		echo '<p class="description">' . esc_html( $field['description'] ) . '</p>';
	}

}




