<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Tagesdokumentation zum Coachingvertrag</title>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
		<style>
			@page {
				margin: 0px;
				font-family: GOTHIC;
			}
            html {
				margin: 0px
			}
            body {
				margin: 0px;
				font-family: GOTHIC;
			}
            h1, h4 {
				font-family: GOTHIC;
			}
            table {
				border-collapse: collapse;
			}
            @font-face {
				font-family: 'GOTHIC';
				font-style: normal;
				font-weight: normal;
				src:
					url(https://app.nextlevel-akademie.de/cosmetic-school/vendor/dompdf/dompdf/lib/fonts/GOTHIC.TTF)
					format('truetype');
			}
            @font-face {
				font-family: 'GOTHICB';
				font-style: normal;
				font-weight: 700;
				src:
					url(https://app.nextlevel-akademie.de/cosmetic-school/vendor/dompdf/dompdf/lib/fonts/GOTHICB.TTF)
					format('truetype');
			}
            table thead tr th {
				font-family: 'GOTHICB';
			}

			b {
				font-family: 'GOTHICB';
			}

			table tbody tr td {
				font-family: 'GOTHIC';
			}

			header {
				position: fixed;
				top: 25px;
				left: 0px;
				right: 0px;
				height: 50px;
			}

			footer {
				position: fixed;
				bottom: 10px;
				left: 0px;
				right: 0px;
				height: 50px;
			}

			.page {
				page-break-after: always;
				overflow: hidden;
			}

			.last-page {
				page-break-after: never;
				overflow: hidden;
			}
		</style>
	</head>

<body style="padding-left: 50px; padding-right: 50px; padding-bottom: 50px; padding-top: 50px">
    <header>
        <table width="520" style="padding-left: 50px; padding-right: 10px; font-size: 14px;">
            <tr>
                <td><img src="images/logo.png" width="250px" height="auto" /></td>
            </tr>
        </table>
    </header>
    <footer>
        <table width="520" style="padding-left: 150px; padding-right: 50px; font-size: 12px;">
            <tr>
                <td align="center" style="color: #9B9B9B;">
                    NextLevel Akademie – Inh. Gülhan Dündar - Bundesallee 86 - 12161 Berlin<br />
                    Tel. 030/89640064 - info@nextlevel-akademie.de - www.nextlevel-akademie.de
                </td>
            </tr>
        </table>
    </footer>
    <main>
    <div class="last-page">
				<table width="520" style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
					<tr>
						<td align="center" style="font-size: 20px;"><b>@lang('forms.tagasdoku_pdf_heading')</b><br /><br /></td>
					</tr>
				</table>
				<table width="520" style="border: 1pt solid black; margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
			
					<tr><td style="padding-left:10px;">
						<b>@lang('forms.date')</b>
						: {{date('d.m.Y',strtotime($appointment->date))}}
					</td></tr>
					<tr><td style="padding-left:10px;">
						<b>@lang('forms.coach')</b>
						: {{$coach->name}}
					</td></tr>
					<tr><td style="padding-left:10px;">
						<b>@lang('forms.coachee')</b>
						: {{$coachee->name}}
					</td></tr>
					<tr><td style="padding-left:10px;">
						<b>@lang('forms.appointment_ue')</b>
						: {{$appointment->ue}}
					</td></tr>
					<tr><td style="padding-left:10px;">
						<b>@lang('forms.module')</b>
						: {{$module->title}}
					</td></tr>
					<tr><td style="padding-left:10px;">
						<b>@lang('forms.module_items')</b>
						: @if(isset($module_item->title)){{$module_item->title}}@endif
					</td></tr>
					@if(isset($attendance->mis_ids) && strlen($attendance->mis_ids) > 0)
					<tr>
						<td style="padding-left:10px;">
							<b>@lang('forms.appointment_mis')</b> : <br />
							<?php  $mis_ids = explode(';',$attendance->mis_ids); ?> @foreach($module_item_services as $key => $mis) @if(in_array($mis->id, $mis_ids)) {{$mis->title}}<br />
							@endif @endforeach
						</td>
					</tr>
					@endif @if(isset($appointment->teaching_method) && strlen($appointment->teaching_method) > 0)
					<tr>
						<td style="padding-left:10px;">
							<b>@lang('forms.teaching_method')</b> : <br />
							<?php  $tea_mets = explode(',',$appointment->teaching_method); ?> @foreach($tea_mets as $tm) {{$tm}}<br />
							@endforeach
						</td>
					</tr>
					@endif
				</table>

				@if($appointment->item_id == env('MI_WEG_ZIEL_PLANUNG', 2798))
					@if((isset($attendance_additional->weg_ziel_planung_plan_a) && strlen($attendance_additional->weg_ziel_planung_plan_a)) ||
						(isset($attendance_additional->weg_ziel_planung_plan_b) && strlen($attendance_additional->weg_ziel_planung_plan_b)) ||
						(isset($attendance_additional->weg_ziel_planung_plan_c) && strlen($attendance_additional->weg_ziel_planung_plan_c)) ||
						(isset($attendance_additional->weg_ziel_planung_plan_d) && strlen($attendance_additional->weg_ziel_planung_plan_d)) ||
						(isset($attendance_additional->weg_ziel_planung_plan_e) && strlen($attendance_additional->weg_ziel_planung_plan_e)))
						
						<table width="520" style="page-break-inside:avoid;border: 1pt solid black; margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
							<tr>
								<td style="padding-left:10px;">Folgende <u>arbeitsmarktnahe</u> Job-Perspektiven wurden erarbeitet: Plan A, Plan B UND Plan C</td>
							</tr>
							@if(isset($attendance_additional->weg_ziel_planung_plan_a) && strlen($attendance_additional->weg_ziel_planung_plan_a))
								<tr>
								<td style="padding-left:20px;">Plan A: <?php echo nl2br($attendance_additional->weg_ziel_planung_plan_a);?><br /></td>
								</tr>
							@endif
							@if(isset($attendance_additional->weg_ziel_planung_plan_b) && strlen($attendance_additional->weg_ziel_planung_plan_b))
								<tr>
								<td style="padding-left:20px;">Plan B: <?php echo nl2br($attendance_additional->weg_ziel_planung_plan_b);?><br /></td>
								</tr>
							@endif
							@if(isset($attendance_additional->weg_ziel_planung_plan_c) && strlen($attendance_additional->weg_ziel_planung_plan_c))
								<tr>
								<td style="padding-left:20px;">Plan C: <?php echo nl2br($attendance_additional->weg_ziel_planung_plan_c);?><br /></td>
								</tr>
							@endif
							@if(isset($attendance_additional->weg_ziel_planung_plan_d) && strlen($attendance_additional->weg_ziel_planung_plan_d))
								<tr>
								<td style="padding-left:20px;">Plan D: <?php echo nl2br($attendance_additional->weg_ziel_planung_plan_d);?><br /></td>
								</tr>
							@endif
							@if(isset($attendance_additional->weg_ziel_planung_plan_e) && strlen($attendance_additional->weg_ziel_planung_plan_e))
								<tr>
								<td style="padding-left:20px;">Plan E: <?php echo nl2br($attendance_additional->weg_ziel_planung_plan_e);?><br /></td>
								</tr>
							@endif
						</table>
					@endif 
				@endif

                @if($appointment->item_id == env('MI_PROFESSIONALE_BEWERBUNGSUNTERLAGEN', 2801))
					@if((isset($attendance_additional->prof_bewerbung_platforms_used) && strlen($attendance_additional->prof_bewerbung_platforms_used)) ||
						(isset($attendance_additional->prof_bewerbung_mappe) && strlen($attendance_additional->prof_bewerbung_mappe)) ||
						isset($attendance_additional->prof_bewerbung_platforms_used_other))
						<table width="520" style="page-break-inside:avoid;border: 1pt solid black; margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
							<tr>
								<td style="padding-left:10px"><b>Folgende Plattformen wurden genutzt (ankreuzen):</b><br/>
								<?php  $platforms = explode(';',$attendance_additional->prof_bewerbung_platforms_used); ?> @foreach($platforms as $pl) 
								@if($pl=='jobborse_fur_stellensuche')Jobbörse für Stellensuche<br />@endif
								@if($pl=='kursnet_fur_weiterbildungen_und_umschulungen')Kursnet für Weiterbildungen und Umschulungen<br />@endif
								@if($pl=='berufsnet_fur_ausfuhrliche_berufsinformationen')Berufenet für ausführliche Berufsinformationen<br />@endif
									@endforeach
								{{preg_replace("/<br.*>/U", PHP_EOL, $attendance_additional->prof_bewerbung_platforms_used_other)}}
							</tr>
						</table>
						<table width="520" style="page-break-inside:avoid;border: 1pt solid black; margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
							<tr>
								<td style="padding-left:10px"><b>Folgende Plattformen wurden genutzt (ankreuzen):</b><br/>
								<?php  $mappe = explode(';',$attendance_additional->prof_bewerbung_mappe); ?> @foreach($mappe as $ma) 
@if($ma=='professionelles_anschreiben_erarbeitet')Professionelles Anschreiben erarbeitet <br />@endif
								@if($ma=='professionellen_lebenslauf_erarbeitet')Professionellen Lebenslauf erarbeitet<br />@endif
								@if($ma=='zertifikate_wurden_fur_die_mappe_zusammengestellt')Zertifikate Wurden für die Mappe Zusammengestellt<br />@endif
								
									@endforeach
							</tr>
						</table>
					@endif
					@if(isset($attendance_additional->prof_bewerbung_sent_cv1) || isset($attendance_additional->prof_bewerbung_sent_cv2) || isset($attendance_additional->prof_bewerbung_sent_cv3) ||
						isset($attendance_additional->prof_bewerbung_sent_cv4) || isset($attendance_additional->prof_bewerbung_sent_cv5) || isset($attendance_additional->prof_bewerbung_sent_cv6) ||
						isset($attendance_additional->prof_bewerbung_sent_cv7) || isset($attendance_additional->prof_bewerbung_sent_cv8) || isset($attendance_additional->prof_bewerbung_sent_cv9) ||
						isset($attendance_additional->prof_bewerbung_sent_cv10) || isset($attendance_additional->prof_bewerbung_sent_cv1_to) || isset($attendance_additional->prof_bewerbung_sent_cv2_to) ||
						isset($attendance_additional->prof_bewerbung_sent_cv3_to) || isset($attendance_additional->prof_bewerbung_sent_cv4_to) || isset($attendance_additional->prof_bewerbung_sent_cv5_to) ||
						isset($attendance_additional->prof_bewerbung_sent_cv6_to) || isset($attendance_additional->prof_bewerbung_sent_cv7_to) || isset($attendance_additional->prof_bewerbung_sent_cv8_to) ||
						isset($attendance_additional->prof_bewerbung_sent_cv9_to) || isset($attendance_additional->prof_bewerbung_sent_cv10_to) || isset($attendance_additional->pdf_bewerbung_sent_cv1_cvs_id) ||
						isset($attendance_additional->pdf_bewerbung_sent_cv2_cvs_id) || isset($attendance_additional->pdf_bewerbung_sent_cv3_cvs_id) || isset($attendance_additional->pdf_bewerbung_sent_cv4_cvs_id) ||
						isset($attendance_additional->pdf_bewerbung_sent_cv5_cvs_id) || isset($attendance_additional->pdf_bewerbung_sent_cv6_cvs_id) || isset($attendance_additional->pdf_bewerbung_sent_cv7_cvs_id) ||
						isset($attendance_additional->pdf_bewerbung_sent_cv8_cvs_id) || isset($attendance_additional->pdf_bewerbung_sent_cv9_cvs_id) || isset($attendance_additional->pdf_bewerbung_sent_cv10_cvs_id)
						)
						<table width="520" style="page-break-inside:avoid;border: 1pt solid black; margin-top: 100px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
							<tr>
								<td style="padding-left:10px">
									@if(isset($attendance_additional->prof_bewerbung_sent_cv1) || isset($attendance_additional->prof_bewerbung_sent_cv1_to) || isset($attendance_additional->pdf_bewerbung_sent_cv1_cvs_id))
										<p><b>CV 1</b>: @if(isset($attendance_additional->prof_bewerbung_sent_cv1)) {{$attendance_additional->prof_bewerbung_sent_cv1}}@endif &nbsp;&nbsp; @if(isset($attendance_additional->prof_bewerbung_sent_cv1_to)) {{$attendance_additional->prof_bewerbung_sent_cv1_to}}@endif &nbsp;&nbsp; 
										@if(isset($attendance_additional->pdf_bewerbung_sent_cv1_cvs_id))
											@foreach($cvs as $cv)
											@if($attendance_additional->pdf_bewerbung_sent_cv1_cvs_id == $cv->id)
												{{ $cv->title }}
											@endif
											@endforeach
										@elseif(isset($attendance_additional->pdf_bewerbung_sent_cv1))
											{{ $attendance_additional->pdf_bewerbung_sent_cv1 }}
										@endif</p>
									@endif
									@if(isset($attendance_additional->prof_bewerbung_sent_cv2) || isset($attendance_additional->prof_bewerbung_sent_cv2_to) || isset($attendance_additional->pdf_bewerbung_sent_cv2_cvs_id))
										<p><b>CV 2</b>: @if(isset($attendance_additional->prof_bewerbung_sent_cv2)) {{$attendance_additional->prof_bewerbung_sent_cv2}}@endif &nbsp;&nbsp; @if(isset($attendance_additional->prof_bewerbung_sent_cv2_to)) {{$attendance_additional->prof_bewerbung_sent_cv2_to}}@endif &nbsp;&nbsp; 
										@if(isset($attendance_additional->pdf_bewerbung_sent_cv2_cvs_id))
											@foreach($cvs as $cv)
											@if($attendance_additional->pdf_bewerbung_sent_cv2_cvs_id == $cv->id)
												{{ $cv->title }}
											@endif
											@endforeach
										@elseif(isset($attendance_additional->pdf_bewerbung_sent_cv2))
											{{ $attendance_additional->pdf_bewerbung_sent_cv2 }}
										@endif</p>
									@endif
									@if(isset($attendance_additional->prof_bewerbung_sent_cv3) || isset($attendance_additional->prof_bewerbung_sent_cv3_to) || isset($attendance_additional->pdf_bewerbung_sent_cv3_cvs_id))
										<p><b>CV 3</b>: @if(isset($attendance_additional->prof_bewerbung_sent_cv3)) {{$attendance_additional->prof_bewerbung_sent_cv3}}@endif &nbsp;&nbsp; @if(isset($attendance_additional->prof_bewerbung_sent_cv3_to)) {{$attendance_additional->prof_bewerbung_sent_cv3_to}}@endif &nbsp;&nbsp; 
										@if(isset($attendance_additional->pdf_bewerbung_sent_cv3_cvs_id))
											@foreach($cvs as $cv)
											@if($attendance_additional->pdf_bewerbung_sent_cv3_cvs_id == $cv->id)
												{{ $cv->title }}
											@endif
											@endforeach
										@elseif(isset($attendance_additional->pdf_bewerbung_sent_cv3))
											{{ $attendance_additional->pdf_bewerbung_sent_cv3 }}
										@endif</p>
									@endif
									@if(isset($attendance_additional->prof_bewerbung_sent_cv4) || isset($attendance_additional->prof_bewerbung_sent_cv4_to) || isset($attendance_additional->pdf_bewerbung_sent_cv4_cvs_id))
										<p><b>CV 4</b>: @if(isset($attendance_additional->prof_bewerbung_sent_cv4)) {{$attendance_additional->prof_bewerbung_sent_cv4}}@endif &nbsp;&nbsp; @if(isset($attendance_additional->prof_bewerbung_sent_cv4_to)) {{$attendance_additional->prof_bewerbung_sent_cv4_to}}@endif &nbsp;&nbsp; 
										@if(isset($attendance_additional->pdf_bewerbung_sent_cv4_cvs_id))
											@foreach($cvs as $cv)
											@if($attendance_additional->pdf_bewerbung_sent_cv4_cvs_id == $cv->id)
												{{ $cv->title }}
											@endif
											@endforeach
										@elseif(isset($attendance_additional->pdf_bewerbung_sent_cv4))
											{{ $attendance_additional->pdf_bewerbung_sent_cv4 }}
										@endif</p>
									@endif
									@if(isset($attendance_additional->prof_bewerbung_sent_cv5) || isset($attendance_additional->prof_bewerbung_sent_cv5_to) || isset($attendance_additional->pdf_bewerbung_sent_cv5_cvs_id))
										<p><b>CV 5</b>: @if(isset($attendance_additional->prof_bewerbung_sent_cv5)) {{$attendance_additional->prof_bewerbung_sent_cv5}}@endif &nbsp;&nbsp; @if(isset($attendance_additional->prof_bewerbung_sent_cv5_to)) {{$attendance_additional->prof_bewerbung_sent_cv5_to}}@endif &nbsp;&nbsp; 
										@if(isset($attendance_additional->pdf_bewerbung_sent_cv5_cvs_id))
											@foreach($cvs as $cv)
											@if($attendance_additional->pdf_bewerbung_sent_cv5_cvs_id == $cv->id)
												{{ $cv->title }}
											@endif
											@endforeach
										@elseif(isset($attendance_additional->pdf_bewerbung_sent_cv5))
											{{ $attendance_additional->pdf_bewerbung_sent_cv5 }}
										@endif</p>
									@endif
									@if(isset($attendance_additional->prof_bewerbung_sent_cv6) || isset($attendance_additional->prof_bewerbung_sent_cv6_to) || isset($attendance_additional->pdf_bewerbung_sent_cv6_cvs_id))
										<p><b>CV 6</b>: @if(isset($attendance_additional->prof_bewerbung_sent_cv6)) {{$attendance_additional->prof_bewerbung_sent_cv6}}@endif &nbsp;&nbsp; @if(isset($attendance_additional->prof_bewerbung_sent_cv6_to)) {{$attendance_additional->prof_bewerbung_sent_cv6_to}}@endif &nbsp;&nbsp; 
										@if(isset($attendance_additional->pdf_bewerbung_sent_cv6_cvs_id))
											@foreach($cvs as $cv)
											@if($attendance_additional->pdf_bewerbung_sent_cv6_cvs_id == $cv->id)
												{{ $cv->title }}
											@endif
											@endforeach
										@elseif(isset($attendance_additional->pdf_bewerbung_sent_cv6))
											{{ $attendance_additional->pdf_bewerbung_sent_cv6 }}
										@endif</p>
									@endif
									@if(isset($attendance_additional->prof_bewerbung_sent_cv7) || isset($attendance_additional->prof_bewerbung_sent_cv7_to) || isset($attendance_additional->pdf_bewerbung_sent_cv7_cvs_id))
										<p><b>CV 7</b>: @if(isset($attendance_additional->prof_bewerbung_sent_cv7)) {{$attendance_additional->prof_bewerbung_sent_cv7}}@endif &nbsp;&nbsp; @if(isset($attendance_additional->prof_bewerbung_sent_cv7_to)) {{$attendance_additional->prof_bewerbung_sent_cv7_to}}@endif &nbsp;&nbsp; 
										@if(isset($attendance_additional->pdf_bewerbung_sent_cv7_cvs_id))
											@foreach($cvs as $cv)
											@if($attendance_additional->pdf_bewerbung_sent_cv7_cvs_id == $cv->id)
												{{ $cv->title }}
											@endif
											@endforeach
										@elseif(isset($attendance_additional->pdf_bewerbung_sent_cv7))
											{{ $attendance_additional->pdf_bewerbung_sent_cv7 }}
										@endif</p>
									@endif
									@if(isset($attendance_additional->prof_bewerbung_sent_cv8) || isset($attendance_additional->prof_bewerbung_sent_cv8_to) || isset($attendance_additional->pdf_bewerbung_sent_cv8_cvs_id))
										<p><b>CV 8</b>: @if(isset($attendance_additional->prof_bewerbung_sent_cv8)) {{$attendance_additional->prof_bewerbung_sent_cv8}}@endif &nbsp;&nbsp; @if(isset($attendance_additional->prof_bewerbung_sent_cv8_to)) {{$attendance_additional->prof_bewerbung_sent_cv8_to}}@endif &nbsp;&nbsp; 
										@if(isset($attendance_additional->pdf_bewerbung_sent_cv8_cvs_id))
											@foreach($cvs as $cv)
											@if($attendance_additional->pdf_bewerbung_sent_cv8_cvs_id == $cv->id)
												{{ $cv->title }}
											@endif
											@endforeach
										@elseif(isset($attendance_additional->pdf_bewerbung_sent_cv8))
											{{ $attendance_additional->pdf_bewerbung_sent_cv8 }}
										@endif</p>
									@endif
									@if(isset($attendance_additional->prof_bewerbung_sent_cv9) || isset($attendance_additional->prof_bewerbung_sent_cv9_to) || isset($attendance_additional->pdf_bewerbung_sent_cv9_cvs_id))
										<p><b>CV 9</b>: @if(isset($attendance_additional->prof_bewerbung_sent_cv9)) {{$attendance_additional->prof_bewerbung_sent_cv9}}@endif &nbsp;&nbsp; @if(isset($attendance_additional->prof_bewerbung_sent_cv9_to)) {{$attendance_additional->prof_bewerbung_sent_cv9_to}}@endif &nbsp;&nbsp; 
										@if(isset($attendance_additional->pdf_bewerbung_sent_cv9_cvs_id))
											@foreach($cvs as $cv)
											@if($attendance_additional->pdf_bewerbung_sent_cv9_cvs_id == $cv->id)
												{{ $cv->title }}
											@endif
											@endforeach
										@elseif(isset($attendance_additional->pdf_bewerbung_sent_cv9))
											{{ $attendance_additional->pdf_bewerbung_sent_cv9 }}
										@endif</p>
									@endif
									@if(isset($attendance_additional->prof_bewerbung_sent_cv10) || isset($attendance_additional->prof_bewerbung_sent_cv10_to) || isset($attendance_additional->pdf_bewerbung_sent_cv10_cvs_id))
										<p><b>CV 10</b>: @if(isset($attendance_additional->prof_bewerbung_sent_cv10)) {{$attendance_additional->prof_bewerbung_sent_cv10}}@endif &nbsp;&nbsp; @if(isset($attendance_additional->prof_bewerbung_sent_cv10_to)) {{$attendance_additional->prof_bewerbung_sent_cv10_to}}@endif &nbsp;&nbsp; 
										@if(isset($attendance_additional->pdf_bewerbung_sent_cv10_cvs_id))
											@foreach($cvs as $cv)
											@if($attendance_additional->pdf_bewerbung_sent_cv10_cvs_id == $cv->id)
												{{ $cv->title }}
											@endif
											@endforeach
										@elseif(isset($attendance_additional->pdf_bewerbung_sent_cv10))
											{{ $attendance_additional->pdf_bewerbung_sent_cv10 }}
										@endif</p>
									@endif
								</td>
							</tr>
						</table>
					@endif
				@endif 
				@if($appointment->item_id == env('MI_DURCHHALTEVERMOEGEN_BELASTBARKEIT', 2793)) 
				@if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_gesund') ||
				str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_familie') || str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_partner') ||
				str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_kinder') || str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_financial') ||
				str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_recht') || str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_sprach') ||
				str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_pflege') || isset($attendance_additional->durch_belast_options_other) )
				<table width="520" style="page-break-inside:avoid;border: 1pt solid black;margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
					<tr>
						<td style="padding-left:10px;padding-right:10px;">Zusätzliche Herausforderungen erschwerten bisher die berufliche Laufbahn/Perspective:</td>
					</tr>
					<tr>
						<td style="padding-left:10px;padding-right:10px;">
							<ul>
								@if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_gesund'))
								<li>gesundheitlich</li>

								@endif @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_familie'))
								<li>familiäre</li>
								@endif @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_partner'))
								<li>partnerschaftliche</li>
								@endif @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_kinder'))
								<li>Kinderbetreuung</li>
								@endif @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_financial'))
								<li>finanzielle</li>
								@endif @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_recht'))
								<li>rechtliche</li>
								@endif @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_sprach'))
								<li>sprachliche/kulturelle</li>
								@endif @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_pflege'))
								<li>Pflege von Angehörigen</li>
								@endif @if(isset($attendance_additional->durch_belast_options_other))
								<li>
									Sonstiges:
									<ul>
										<li><?php echo nl2br($attendance_additional->durch_belast_options_other);?></li>
									</ul>
								</li>

								@endif
							</ul>
						</td>
					</tr>
				</table>
				<br />
				@endif @endif 
				@if($appointment->item_id == env('MI_MOEGLICHKEITEN_VISIONEN', 2794)) 
				@if(isset($attendance_additional->moeglich_vision_competence) || isset($attendance_additional->moeglich_vision_experience))

				<table width="520" style="page-break-inside:avoid;border: 1pt solid black; margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
					<tr>
						<td style="padding-left:10px;padding-right:10px;">
							<b><u>Kompetenzanalyse</u></b>
						</td>
					</tr>
					@if(isset($attendance_additional->moeglich_vision_competence))
					<tr>
						<td style="padding-left:10px;padding-right:10px;">
							<b>Welche Abschlüsse und Qualifikationen bringt der Coachee mit:</b><br />
							<?php echo nl2br($attendance_additional->moeglich_vision_competence);?><br />
						</td>
					</tr>
					@endif @if(isset($attendance_additional->moeglich_vision_experience))
					<tr>
						<td style="padding-left:10px;padding-right:10px;">
							<br />
							<b>Berufserfahrungen:</b><br />
							<?php echo nl2br($attendance_additional->moeglich_vision_experience);?><br />
						</td>
					</tr>
					@endif
				</table>

				@endif @endif 
				@if($appointment->item_id == env('MI_SELBST_UND_FREMDWAHRNEHMUNG_TEIL_1', 2792)) 
				@if(isset($attendance_additional->selbst_fremd_strengths) || isset($attendance_additional->selbst_fremd_weakness) ||
				isset($attendance_additional->selbst_fremd_potential) || isset($attendance_additional->selbst_fremd_energykiller) || isset($attendance_additional->selbst_fremd_energygiver) ||
				isset($attendance_additional->selbst_fremd_ziel_planung) || isset($attendance_additional->selbst_fremd_beruf_persp))
				<table width="520" style="page-break-inside:avoid;border: 1pt solid black;  margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
					<tr><td style="padding-left:10px;padding-right:10px;"><b>Berufliche Kompetenzen / neu entdeckte Potentiale / neu entdeckte berufliche Perspektiven:</b></td></tr>
					<tr><td style="padding-left:10px;padding-right:10px;"><b><u>Resourceanalyse / neue berufliche Potentiale:</u></b></td></tr>
					
					
					@if(isset($attendance_additional->selbst_fremd_strengths))
					<tr><td style="padding-left:10px;padding-right:10px;">
					<b>Stärken:</b>
					<br />
					<?php echo nl2br($attendance_additional->selbst_fremd_strengths);?>
					</td></tr>
					@endif 
					@if(isset($attendance_additional->selbst_fremd_weakness))
					<tr><td style="padding-left:10px;padding-right:10px;">
					<b>Schwächen:</b>
					<br />
					<?php echo nl2br($attendance_additional->selbst_fremd_weakness);?>
					</td></tr>
					@endif 
					@if(isset($attendance_additional->selbst_fremd_potential))
					<tr><td style="padding-left:10px;padding-right:10px;">
					<b>Neu entdeckte Potentiale:</b>
					<br />
					<?php echo nl2br($attendance_additional->selbst_fremd_potential);?>
					</td></tr>
					@endif 
					@if(isset($attendance_additional->selbst_fremd_energykiller))
					<tr><td style="padding-left:10px;padding-right:10px;">
					<b>Energiekiller:</b>
					<br />
					<?php echo nl2br($attendance_additional->selbst_fremd_energykiller);?>
					</td></tr>
					@endif 
					@if(isset($attendance_additional->selbst_fremd_energygiver))
					<tr><td style="padding-left:10px;padding-right:10px;">
					<b>Energiegeber:</b>
					<br />
					<?php echo nl2br($attendance_additional->selbst_fremd_energygiver);?>
					</td></tr>
					@endif 
					@if(isset($attendance_additional->selbst_fremd_ziel_planung) || isset($attendance_additional->selbst_fremd_beruf_persp))
					<hr />
					@if(isset($attendance_additional->selbst_fremd_ziel_planung))
					<tr><td style="padding-left:10px;padding-right:10px;">
					<b>Neue berufliche Zielstellung & Weg-Ziel Planung:</b>
					<br />
					<?php echo nl2br($attendance_additional->selbst_fremd_ziel_planung);?>
					</td></tr>
					@endif 
					@if(isset($attendance_additional->selbst_fremd_beruf_persp))
					<tr><td style="padding-left:10px;padding-right:10px;">
					<b>Neue entdekte berufliche Perspektiven:</b>
					<br />
					<?php echo nl2br($attendance_additional->selbst_fremd_beruf_persp);?>
					</td></tr>
					@endif 
					@endif
				</table>
				
				@endif @endif 
				@if(isset($next_appointment->date))
				<table width="520" style="page-break-inside:avoid; border: 1pt solid black;  margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
					<tr>
						<td style="padding-left:10px;padding-right:10px;"><b>@lang('forms.next_appointment')</b></td>
					</tr>
					<tr>
						<td style="padding-left:10px;padding-right:10px;"><b>Datum & Uhrzeit</b> : {{date('d.m.Y',strtotime($next_appointment->date))}} {{$next_appointment->time}} - {{$next_appointment->time_end}}</td>
					</tr>
					<tr>
						<td style="padding-left:10px;padding-right:10px;"><b>Modul & Modulitem</b> : {{$next_appointment->title}}</td>
					</tr>
				</table>
				@endif

                <table width="520" style="page-break-inside:avoid;border: 1pt solid black; margin-top: 40px; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom: 10px; font-size: 14px;">
					<tr>
					<td align="left" style="width:40%; padding-left:10px">
                            <b><u>@lang('forms.coaching_verhalten')</u></b>
                        </td>
                        <td align="left" style="width:30%; padding-top:10px">
                        </td>
                        <td align="left" style="width:30%; padding-top:10px">
                        </td>
                    </tr>
                        
					<tr style="border-bottom: 1pt solid black">
                        <td align="left" style="width:40%; padding-left:10px">
                            <b>@lang('forms.vorbildlich')</b>
                        </td>
                        <td align="left" style="width:30%; padding-top:10px">
                        <?php
                            $vorbildlich = isset($attendance_verhalten->vorbildlich) ? $attendance_verhalten->vorbildlich :'';
                            for ($i = 1; $i <= $vorbildlich; $i++) {
                                ?>
                                <img src="images/star.png" />
                                <?php
                            }
							?>
						</td>
						<td align="left" style="width: 30%">
						<?php
							$rating = $vorbildlich;
                            if($rating == 1)
                                echo '&nbsp;stark unterdurchschnittlich';
                            else if ($rating == 2)
                                echo '&nbsp;knapp unterdurchschnittlich';
                            else if ($rating == 3)
                                echo '&nbsp;den Anforderungen entsprechend';
                            else if ($rating == 4)
                                echo '&nbsp;überdurchschnittlich';
                            else if ($rating == 5)
                                echo '&nbsp;ausgezeichnet';
                        ?>
                    	</td>
                    </tr>
                    <tr style="border: 1pt solid black">
                        <td align="left" style="width:40%; padding-left:10px">
							<b>@lang('forms.sucht_loesungen')</b>
                        </td>
                        <td align="left" style="width:30%; padding-top:10px">
                        <?php
                            $sucht_loesungen = isset($attendance_verhalten->sucht_loesungen) ? $attendance_verhalten->sucht_loesungen :'';
                            for ($i = 1; $i <= $sucht_loesungen; $i++) {
                                ?>
                                <img src="images/star.png" />
                                <?php
                            }
							?>
						<td align="left" style="width:30%">
							<?php
                            $rating = $sucht_loesungen;
                            if($rating == 1)
                                echo '&nbsp;stark unterdurchschnittlich';
                            else if ($rating == 2)
                                echo '&nbsp;knapp unterdurchschnittlich';
                            else if ($rating == 3)
                                echo '&nbsp;den Anforderungen entsprechend';
                            else if ($rating == 4)
                                echo '&nbsp;überdurchschnittlich';
                            else if ($rating == 5)
                                echo '&nbsp;ausgezeichnet';
                        ?>
                    </td>
                    </tr>
                    <tr style="border-bottom: 1pt solid black">
                        <td align="left" style="width:40%; padding-left:10px">
							<b>@lang('forms.agiert_entscheidung')</b>
                        </td>
                        <td align="left" style="width:30%; padding-top:10px">
                        <?php
                            $agiert_entscheidung = isset($attendance_verhalten->agiert_entscheidung) ? $attendance_verhalten->agiert_entscheidung :'';
                            for ($i = 1; $i <= $agiert_entscheidung; $i++) {
                                ?>
                                <img src="images/star.png" />
                                <?php
                            }
							?>
						<td align="left" style="width:30%">
							<?php
                            $rating = $agiert_entscheidung;
                            if($rating == 1)
                                echo '&nbsp;stark unterdurchschnittlich';
                            else if ($rating == 2)
                                echo '&nbsp;knapp unterdurchschnittlich';
                            else if ($rating == 3)
                                echo '&nbsp;den Anforderungen entsprechend';
                            else if ($rating == 4)
                                echo '&nbsp;überdurchschnittlich';
                            else if ($rating == 5)
                                echo '&nbsp;ausgezeichnet';
                        ?>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1pt solid black">
                        <td align="left" style="width:40%; padding-left:10px">
							<b>@lang('forms.motiviert_konflikt_solve')</b>
                        </td>
                        <td align="left" style="width:30%; padding-top:10px">
                        <?php
                            $motiviert_konflikt_solve = isset($attendance_verhalten->motiviert_konflikt_solve) ? $attendance_verhalten->motiviert_konflikt_solve :'';
                            for ($i = 1; $i <= $motiviert_konflikt_solve; $i++) {
                                ?>
                                <img src="images/star.png" />
                                <?php
                            }
							?>
						<td align="left" style="width:30%">
							<?php
                            $rating = $motiviert_konflikt_solve;
                            if($rating == 1)
                                echo '&nbsp;stark unterdurchschnittlich';
                            else if ($rating == 2)
                                echo '&nbsp;knapp unterdurchschnittlich';
                            else if ($rating == 3)
                                echo '&nbsp;den Anforderungen entsprechend';
                            else if ($rating == 4)
                                echo '&nbsp;überdurchschnittlich';
                            else if ($rating == 5)
                                echo '&nbsp;ausgezeichnet';
                        ?>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1pt solid black">
                        <td align="left" style="width:40%; padding-left:10px">
							<b>@lang('forms.motiviert_problem_solve')</b>
                        </td>
                        <td align="left" style="width:30%; padding-top:10px">
                        <?php
                            $motiviert_problem_solve = isset($attendance_verhalten->motiviert_problem_solve) ? $attendance_verhalten->motiviert_problem_solve :'';
                            for ($i = 1; $i <= $motiviert_konflikt_solve; $i++) {
                                ?>
                                <img src="images/star.png" />
                                <?php
                            }
							?>
						<td align="left" style="width:30%">
							<?php
                            $rating = $motiviert_problem_solve;
                            if($rating == 1)
                                echo '&nbsp;stark unterdurchschnittlich';
                            else if ($rating == 2)
                                echo '&nbsp;knapp unterdurchschnittlich';
                            else if ($rating == 3)
                                echo '&nbsp;den Anforderungen entsprechend';
                            else if ($rating == 4)
                                echo '&nbsp;überdurchschnittlich';
                            else if ($rating == 5)
                                echo '&nbsp;ausgezeichnet';
                        ?>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1pt solid black">
                        <td align="left" style="width:40%; padding-left:10px">
							<b>@lang('forms.formuliert_klare_erwartung')</b>
                        </td>
                        <td align="left" style="width:30%; padding-top:10px">
                        <?php
                            $formuliert_klare_erwartung = isset($attendance_verhalten->formuliert_klare_erwartung) ? $attendance_verhalten->formuliert_klare_erwartung :'';
                            for ($i = 1; $i <= $formuliert_klare_erwartung; $i++) {
                                ?>
                                <img src="images/star.png" />
                                <?php
                            }
							?>
						<td align="left" style="width:30%">
							<?php
                            $rating = $formuliert_klare_erwartung;
                            if($rating == 1)
                                echo '&nbsp;stark unterdurchschnittlich';
                            else if ($rating == 2)
                                echo '&nbsp;knapp unterdurchschnittlich';
                            else if ($rating == 3)
                                echo '&nbsp;den Anforderungen entsprechend';
                            else if ($rating == 4)
                                echo '&nbsp;überdurchschnittlich';
                            else if ($rating == 5)
                                echo '&nbsp;ausgezeichnet';
                        ?>
                        </td>
                    </tr>
                </table>

				<table width="520" style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
					<tr>
						<td align="center">
							@if(isset($attendance->id)) @if(!empty($attendance->teacher_signature))
							<img src="signatures/{{$attendance->teacher_signature}}" />
							@endif @endif
						</td>
						<td align="center">
							@if(isset($attendance->id)) @if(!empty($attendance->student_signature))
							<img src="signatures/{{$attendance->student_signature}}" />
							@endif @endif
						</td>
					</tr>
					<tr>
						<td align="center">@lang('forms.coach_signature')</td>
						<td align="center">@lang('forms.coachee_signature')</td>
					</tr>
				</table>
			</div>
    </main>
</body>