<script>
	
	$(document).ready(function() {

		var date = new Date();
		var yyyy = date.getFullYear().toString();
		var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
		var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
	   
		$('#calendar').fullCalendar({
		   header: {
			    language: 'es',
				left: 'title',
				right: 'today prev, next',
			},
			defaultDate: yyyy+"-"+mm+"-"+dd,
			eventLimit: true, 
			selectable: true,
			selectHelper: true,
			
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #title').val(event.title).prop("disabled", true);
					$('#ModalEdit #usuario').html(event.cedulas)
					$('#ModalEdit #hstart').val(event.hstart).prop("disabled", true);
					$('#ModalEdit #hend').val(event.hend).prop("disabled", true);
					$('#ModalEdit').modal('show').prop('disabled', true);
				});
			},
			events: [
				<?php foreach($events as $event): 
					$title = $event->title;
					switch($title){
						case 8: $title = 'Gestion Administrativa';  break;
						case 10: $title = 'Cartera Propia'; 		break;
						case 11: $title = 'Colsubsidio';   			break;
						case 12: $title = 'Claro'; 		   			break;
						case 13: $title = 'Credivalores';   		break;
						case 14: $title = 'Santander';      		break;
						case 15: $title = 'Vanti'; 		   			break;
					}

					$json = base64_decode($event->usuarios);
					$cedulas = json_decode($json, true);

					$comp = [];
					foreach($usuarios as $usuario){
						array_push($comp, $usuario->cedula);
					}

					if($cedulas == null){
						$same = array_merge(array_intersect($comp, [0]));
						$nosame = array_merge(array_diff($comp, [0]));

					}
					else{
						$same = array_merge(array_intersect($comp, $cedulas));
						$nosame = array_merge(array_diff($comp, $cedulas));

					}

					$start = $event->start;
					$end = $event->end;
					$hstart = $event->hstart;
					$hend = $event->hend;

					if(Auth::user()->id_unidad == $event->campaña){
				?>
				{
					id: '<?php echo $event->id; ?>',
					title: '<?php echo $title; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
					hstart: '<?php echo $hstart ?>',
					hend: '<?php echo $hend ?>',
					color: '<?php echo $event->color; ?>',
					
					cedulas: `<?php 
						foreach($usuarios as $usuario){
							if($usuario->id_unidad == Auth::user()->id_unidad){
								foreach($same as $s){
									if($usuario->cedula == $s){
										switch($usuario->id_unidad){
											case 1:
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." checked disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Calidad / Monitoreo</td>
												</tr>";
											break;
											case 8: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." checked disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Gestion Documental</td>
												</tr>";
											break;
											case 9:
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." checked disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Formacion</td>
												</tr>";
											break;
											case 10: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." checked disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Cartera Propia</td>
												</tr>";
											break;
											case 11: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." checked disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Colsubsidio</td>
												</tr>";
											break;
											case 12: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." checked disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Claro</td>
												</tr>";
											break;
											case 13: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." checked disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Credivalores</td>
												</tr>";
											break;
											case 14: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." checked disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Santander</td>
												</tr>";
											break;
											case 15: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." checked disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Vanti</td>
												</tr>";
											break;
										}
										
									}
								}
								foreach($nosame as $ns){
									if($usuario->cedula == $ns){
										switch($usuario->id_unidad){
											case 1:
												echo
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuarios->cedula."</td>
													<td>Calidad / Monitoreo</td>
												</tr>";
											break;
											case 8: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Gestion Documental</td>
												</tr>";
											break;
											case 9:
												echo
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value='.$usuario->cedula.' disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Formacion</td>
												</tr>";
											break;
											case 10: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Cartera Propia</td>
												</tr>";
											break;
											case 11: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Colsubsidio</td>
												</tr>";
											break;
											case 12: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Claro</td>
												</tr>";
											break;
											case 13: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Credivalores</td>
												</tr>";
											break;
											case 14: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Santander</td>
												</tr>";
											break;
											case 15: 
												echo 
												"<tr>
													<th scope='row'><input name='cedula[]' type='checkbox' value=".$usuario->cedula." disabled></th>
													<td>".$usuario->nombre."</td>
													<td>".$usuario->cedula."</td>
													<td>Vanti</td>
												</tr>";
											break;
										}
									}
								}
							}
						}
					?>`,
					
				},
				<?php } endforeach; ?>
			]
		});
		
	});
	
</script>
