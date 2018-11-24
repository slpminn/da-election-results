<?php

/**
 * Adds DA Election Results widget.
 */
class DA_Election_Results_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'da_election_results_widget', // Base ID
			esc_html__( 'Widget DA Election Results', 'da_election_results_domain' ), // Name
			array( 'description' => esc_html__( 'Displays Election Results', 'da_election_results_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		if ( ! empty( $instance['active'] ) ) {

			echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}

			if ( ! empty( $instance['races'] ) ) {

				echo $args['before_race'];
				
				$races = explode(',', $instance['races']);
				foreach ($races as $race) {
					//echo $race, '<br />';
					$this->da_election_results_create_race_html( $race, $instance['noCandidates'], $instance['linkURL'], $instance['linkLabel'] );
				}

				echo $args['after_race'];
			}

			//echo esc_html__( 'Hello, World!', 'da_election_results_domain' );

			echo $args['after_widget'];
	
		}

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'da_election_results_domain' );

		$banner = ! empty( $instance['banner'] ) ? $instance['banner'] : esc_html__( '', 'da_election_results_domain' );

		$races = ! empty( $instance['races'] ) ? $instance['races'] : esc_html__( '', 'da_election_results_domain' );

		$noCandidates = ! empty( $instance['noCandidates'] ) ? $instance['noCandidates'] : esc_html__( '99', 'da_election_results_domain' );	

		$linkURL = ! empty( $instance['linkURL'] ) ? $instance['linkURL'] : esc_html__( '/election/', 'da_election_results_domain' );

		$linkLabel = ! empty( $instance['linkLabel'] ) ? $instance['linkLabel'] : esc_html__( 'Full Results', 'da_election_results_domain' );

		$active = ! empty( $instance['active'] ) ? $instance['active'] : esc_html__( '', 'da_election_results_domain' );
		
		?>
		<p>
		<label 
			for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'da_election_results_domain' ); ?>			
		</label> 
		<input 
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
		<label 
			for="<?php echo esc_attr( $this->get_field_id( 'banner' ) ); ?>"><?php esc_attr_e( 'Banner:', 'da_election_results_domain' ); ?>			
		</label> 
		<input 
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'banner' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'banner' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $banner ); ?>">
		</p>

		<p>
		<label 
			for="<?php echo esc_attr( $this->get_field_id( 'races' ) ); ?>"><?php esc_attr_e( 'Races:', 'da_election_results_domain' ); ?>			
		</label> 
		<input 
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'races' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'races' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $races ); ?>">
		</p>	

		<p>
		<label 
			for="<?php echo esc_attr( $this->get_field_id( 'noCandidates' ) ); ?>"><?php esc_attr_e( 'No. Candidates:', 'da_election_results_domain' ); ?>	<small>Candiates to display</small>		
		</label> 
		<input 
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'noCandidates' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'noCandidates' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $noCandidates ); ?>">
		</p>		
		
		<p>
		<label 
			for="<?php echo esc_attr( $this->get_field_id( 'linkURL' ) ); ?>"><?php esc_attr_e( 'Link URL:', 'da_election_results_domain' ); ?> <small>If blank, default URL.</small>			
		</label> 
		<input 
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'linkURL' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'linkURL' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $linkURL ); ?>">
		</p>	

		<p>
		<label 
			for="<?php echo esc_attr( $this->get_field_id( 'linkLabel' ) ); ?>"><?php esc_attr_e( 'Link Label:', 'da_election_results_domain' ); ?> <small>If blank, Full Result.</small>			
		</label> 
		<input 
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'linkLabel' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'linkLabel' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $linkLabel ); ?>">
		</p>	

		<p>
		<label 
			for="<?php echo esc_attr( $this->get_field_id( 'acive' ) ); ?>"><?php esc_attr_e( 'Active:', 'da_election_results_domain' ); ?>			
		</label> 
		<input 
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'active' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'active' ) ); ?>" 
			type="checkbox" 
			value="1"
			<?php echo ($active) ? 'checked' : ''; ?> >
		</p>		
			
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		$instance['banner'] = ( ! empty( $new_instance['banner'] ) ) ? sanitize_text_field( $new_instance['banner'] ) : '';	
		
		$instance['races'] = ( ! empty( $new_instance['races'] ) ) ? sanitize_text_field( $new_instance['races'] ) : '';

		$instance['noCandidates'] = ( ! empty( $new_instance['noCandidates'] ) ) ? sanitize_text_field( $new_instance['noCandidates'] ) : '99';

		$instance['linkURL'] = ( ! empty( $new_instance['linkURL'] ) ) ? sanitize_text_field( $new_instance['linkURL'] ) : '/elections';

		$instance['linkLabel'] = ( ! empty( $new_instance['linkLabel'] ) ) ? sanitize_text_field( $new_instance['linkLabel'] ) : 'Full Results';

		$instance['active'] = sanitize_text_field( $new_instance['active'] );

		return $instance;
	}

	private function da_election_results_create_race_html( $param_race, $param_cands, $param_link_URL, $param_link_label ) {

		global $wpdb;
		$raceUniqueID  = filter_var( sanitize_text_field( $param_race ), FILTER_SANITIZE_STRING ) ;
		$candidates = filter_var( sanitize_text_field( $param_cands ), FILTER_SANITIZE_NUMBER_INT ) ; 
		$linkURL = filter_var( sanitize_text_field( $param_link_URL ), FILTER_SANITIZE_STRING ) ;
		$linkLabel = filter_var( sanitize_text_field( $param_link_label ), FILTER_SANITIZE_STRING ) ;

		echo $instance['linkLabel'];

		$query = "SELECT raceUniqueID, title1, title2, lastUpdated, precintsPercentage FROM da_election_races WHERE raceUniqueID = %s";
		$race = $wpdb->get_row( $wpdb->prepare( $query, $raceUniqueID) ); // or die( $wpdb->last_error );

		$query = "SELECT * FROM da_election_candidates WHERE raceUniqueID = %s ORDER BY numberVotes Desc LIMIT %d";
		$params = array( $raceUniqueID, $candidates );
		$candidates = $wpdb->get_results( $wpdb->prepare( $query, $params ) ); //or die( $wpdb->last_error );

		?>

		<div class="row" style="border: 1px solid black;margin: 5px 5px 5px 5px;">
			<div class="col-12" style=""><h6><?php echo esc_html($race->title1); ?></h6></div>
			<div class="col-12"><small><?php echo 'Reporting: ', esc_html($race->precintsPercentage), '%'; ?></small></div>
			<?php foreach ($candidates as $cand) { ?>
				<div class="col-1"><small><?php echo ($cand->winner) ? 'X' : ' '; ?></small></div>
				<div class="col-9">
					<small><?php echo esc_html($cand->lastName), '(', esc_html($cand->affiliation), ')'; ?></small>
				</div>
				<div class="col-2">
					<small><?php echo esc_html($cand->percentageVotes), '%'; ?></small>
				</div>
			<?php } ?>
			<?php $qparams = array( 'race' => $race->raceUniqueID ); ?>
			<div class="col-11">
				<a href="<?php echo add_query_arg($qparams, $linkURL); ?>"><small><?php echo $linkLabel; ?></small></a>
			</div>
		</div>

		<?php
		
	}

} // class Foo_Widget