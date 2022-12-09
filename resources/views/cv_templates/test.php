
<!doctype html>
<html lang=en-US>

<head>
	<link rel=stylesheet href='css/style.min.css' type=text/css media=all>
	<link rel=stylesheet href=css/main.css?x79211 type=text/css media=all>
	<link rel=stylesheet href=css/commoncalculator.css type=text/css media=all>
	<link rel=stylesheet href=css/loancalculator.css type=text/css media=all>
<script src='js/jquery.min.js'></script>
	<script src='js/jquery-migrate.min.js' id=jquery-migrate-js></script>

</head>

<body class="page-template page-template-template-loancalculator page-template-template-loancalculator-php page page-id-2416 loan-calculator">
	
	<div class="wrap container" role=document>
		<div class="content row">
			<main class=main>
				<article class="post-2416 page type-page status-publish hentry">
					<div class=page-header>
					
					<div class=calculatorcontainer>
						<div class=loancalculatorcontainer>
							<div id=loanformcontainer class=row>
								<div id=loancalculatordashboard class=col-sm-12>
									<ul class=loancalculator-nav style="display: none">
										<li id=emi-calc class=active><a href=# class=hidden-ts></a><a href=# class=visible-ts></a></li>
									</ul>
									<div class=cleardiv></div>
									<div id=loancalculatorinnerformwrapper>
										<form class=form-horizontal id=loancalculatorform>
											<div id=loancalculatorinnerform>
												<div id=lamountwrapper class=toggle-visible>
													<div class="row form-group lamount">
														<label class="col-lg-4 control-label" for=loanamount>Loan Amount</label>
														<div class=col-lg-6>
															<div class=input-group>
																<input class=form-control id=loanamount name=loanamount value=10,00,00 type=text>
																<div class=input-group-append> <span class=input-group-text>$</span></div>
															</div>
														</div>
													</div>
													<div id=loanamountslider></div>
													<div id=loanamountsteps class=steps>
													</div>
												</div>
												<div id=lemiwrapper class="sep toggle-visible">
													<div class="sep row form-group lemi">
														<label class="col-lg-4 control-label" for=loanemi>EMI</label>
														<div class=col-lg-6>
															<div class=input-group>
																<input class=form-control id=loanemi name=loanemi value=21,617.95 type=text>
																<div class=input-group-append> <span class=input-group-text>$</span></div>
															</div>
														</div>
													</div>
													<div id=loanemislider></div>
													<div id=loanemisteps class=steps> 
													</div>
												</div>
												<div id=lintwrapper class="sep toggle-visible" style="display: none">
													<div class="sep row form-group lint">
														<label class="col-lg-4 control-label" for=loaninterest>Interest Rate</label>
														<div class=col-lg-6>
															<div class=input-group>
																<input class=form-control id=loaninterest name=loaninterest value=2.5 type=text>
																<div class=input-group-append> <span class=input-group-text>%</span></div>
															</div>
														</div>
													</div>
													<div id=loaninterestslider></div>
													<div id=loanintereststeps class=steps> 
													</div>
												</div>
												<div id=ltermwrapper class="sep toggle-visible">
													<div class="sep row form-group lterm">
														<label class="col-lg-4 control-label" for=loanterm>Loan Tenure</label>
														<div class=col-lg-6>
															<div class=loantermwrapper>
																<div class=input-group>
																	<input class=form-control id=loanterm name=loanterm value=5 type=text>
																	<div class="input-group-append tenure-choice" data-toggle=buttons>
																		<div class="btn-group btn-group-toggle" data-toggle=buttons>
																			<label class="btn btn-secondary">
																				<input type=radio name=loantenure value=loanyears id=loanyears tabindex=4 autocomplete=off >Yr </label>
																			<label class="btn btn-secondary active">
																				<input type=radio name=loantenure value=loanmonths id=loanmonths tabindex=5 autocomplete=off checked=checked>Mo </label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div id=loantermslider></div>
													<div id=loantermsteps class=steps> 
													</div>
												</div>
												<div id=lfeeswrapper class="sep toggle-visible" style="display: none;">
													<div class="sep row form-group lfees">
														<label class="col-lg-4 control-label" for=loanfees>Fees &amp; Charges</label>
														<div class=col-lg-6>
															<div class=input-group>
																<input class=form-control id=loanfees name=loanfees value=0 type=text>
																<div class=input-group-append> <span class=input-group-text>$</span></div>
															</div>
														</div>
													</div>
													<div id=loanfeesslider></div>
													<div id=loanfeessteps class=steps> 
													</div>
												</div>
												<div id=leschemewrapper class="sep toggle-visible">
													<div class="sep row form-group escheme" style="display: none;">
														<div class=col-lg-8>
															<div class="input-group emischemes">
																<div class="btn-group btn-group-toggle add-check" data-toggle=buttons>
																	
																	<label class="btn btn-secondary active">
																		<input type=radio name=emischeme id=emiarrears value=emiarrears tabindex=5 autocomplete=off checked=checked></label>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<input id=loancalc name=loancalc value type=hidden>
											<input id=loanstartdate name=loanstartdate value type=hidden>
											<input id=loandata name=loandata value type=hidden>
											<input id=calcversion name=calcversion value=4.0 type=hidden>
										</form>
										<div id=loancalc-message class=toggle-hidden>
											<p class="bg-warning text-warning">Note: <span>Error Message</span></p>
										</div>
										<div class="row gutter-left gutter-right">
											<div id=loansummary class="col-sm-5 col-md-6 no-gutter-left no-gutter-right">
												<div id=loansummary-loanamount class=toggle-hidden>
													<h4>Principal Loan Amount</h4>
													<p>$<span>10,00,000</span></p>
												</div>
												<div id=loansummary-emi>
													<h4>Loan EMI</h4>
													<p>$<span>21,617.95</span></p>
												</div>
												<div id=loansummary-tenure class=toggle-hidden>
													<h4>Loan Tenure</h4>
													<p><span>60</span>months</p>
												</div>
												<div id=loansummary-interestrate class=toggle-hidden>
													<h4>Loan Interest Rate</h4>
													<p><span>10.75</span>%</p>
												</div>
												
												<div id=loansummary-totalinterest>
													<h4>Total Interest Payable</h4>
													<p>$<span>2,97,077</span></p>
												</div>
												<div id=loansummary-totalamount>
													<h4>Total Payment<br>(Principal + Interest + Fees &amp; Charges)</h4>
													<p>$<span>13,07,077</span></p>
												</div>
											</div>
											<div id=loansummary-piechart class="no-gutter-left no-gutter-right col-sm-7 col-md-6 highcharts-container"></div>
										</div>
									</div>
								</div>
							</div>
							<div id=loanpaymentdetails>
								<form class="gutter-left gutter-right form-horizontal">
									<div class="row form-group" id=loanpaymentscheduleheader>
										<label class="col-sm-6 control-label" for=startmonthyear>Schedule showing EMI payments starting from</label>
										<div class="col-sm-6 col-md-4">
											<div class=input-group>
												<input class=form-control id=startmonthyear name=startmonthyear value type=text>
												<div class=input-group-append> <span class=input-group-text><i
class="far fa-calendar-alt"></i></span></div>
											</div>
										</div>
									</div>
								</form>
								<div style="display: none">
								<div id=loanpaymentbarchart class="hidden-ts highcharts-container" style="display: n.one"></div>
								</div>
								<div id=loanpaymenttable></div>
								
								
							</div>
						</div>
					</div>
				
				</article>
			</main>
		</div>
	</div>

	<form action="sendmail.php" method="post">
		<input type="text" name="email">
		<input type="submit" name="submit">
		
	</form>
	<script src=js/main.js></script>
	<script src='js/core.min.js'></script>
	<script src='js/mouse.min.js'></script>
	<script src='js/slider.min.js'></script>
	<script src=js/commoncalculator.js ></script>
	<script src=js/loancalculator.js></script>
	
</body>

</html>