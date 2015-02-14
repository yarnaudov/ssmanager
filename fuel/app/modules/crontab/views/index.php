
<form class="form-horizontal" >
	<div class="form-group" >
		<label class="control-label col-sm-1" >Email</label>
		<div class="col-md-4" >
			<input type="text" class="form-control input-sm" name="email" >
		</div>
		<div class="col-md-4" >
			<button class="btn btn-sm btn-default" id="crontab-change-email">Update</button>
		</div>
	</div>
</form>

<div class="row" >
	
	<div class="col-md-12" >
		<table id="cronjobs-table" class="table table-bordered table-striped table-hover">
			
			<thead>
				<tr>
					<th>#</th>
					<th>Minute</th>
					<th>Hour</th>
					<th>Day of month</th>
					<th>Month</th>
					<th>Day of week</th>
					<th>Command</th>
					<th>Actions</th>
				</tr>
			</thead>
			
			<tbody></tbody>
			
		</table>

	</div>
	
</div>

<div class="row" >
	<div class="col-md-12" >
		<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addCronJobModal" ><i class="glyphicon glyphicon-plus" ></i> Add new cronjob</button>
	</div>
</div>

<script type="text/template" id="cronjob-row" >
	<tr>
		<td>{{numb}}</td>
		<td>{{min}}</td>
		<td>{{hour}}</td>
		<td>{{day}}</td>
		<td>{{month}}</td>
		<td>{{weekday}}</td>
		<td>{{command}}</td>
		<td>
			<a href="#" ><i class="glyphicon glyphicon-pencil" ></i></a> 
			<a href="#" ><i class="glyphicon glyphicon-trash" ></i></a> 
		</td>
	</tr>
</script>

<script type="text/template" id="cronjob-empty-row" >
	<tr>
		<td colspan="9" >No Cron Jobs</td>
	</tr>
</script>


<div class="modal fade" id="addCronJobModal" >
	<div class="modal-dialog">
		<div class="modal-content">
			
			<form class="form-horizontal" method="post" >
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Add Cron job</h4>
				</div>
				<div class="modal-body">

					<div class="form-group" >
						<div class="col-md-10 col-md-offset-2" >
							<select class="form-control input-sm options" data-type="common" >
								<option value="--">-- Common Settings --</option>
								<option value="* * * * *">Once Per Minute (* * * * *)</option>
								<option value="*/5 * * * *">Once Per Five Minutes (*/5 * * * *)</option>
								<option value="0,30 * * * *">Twice Per Hour (0,30 * * * *)</option>
								<option value="0 * * * *">Once Per Hour (0 * * * *)</option>
								<option value="0 0,12 * * *">Twice Per Day (0 0,12 * * *)</option>
								<option value="0 0 * * *">Once Per Day (0 0 * * *)</option>
								<option value="0 0 * * 0">Once Per Week (0 0 * * 0)</option>
								<option value="0 0 1,15 * *">On the 1st and 15th of the Month (0 0 1,15 * *)</option>
								<option value="0 0 1 * *">Once Per Month (0 0 1 * *)</option>
								<option value="0 0 1 1 *">Once Per Year (0 0 1 1 *)</option>
							</select>
						</div>
					</div>
					
					<div class="form-group" >
						<label class="control-label col-md-2" >Minute</label>
						<div class="col-md-2" >
							<input type="text" class="form-control input-sm" name="min">
						</div>
						<div class="col-md-6" >
							<select class="form-control input-sm options" data-type="min" >
								<option value="--">-- Common Settings --</option>
								<option value="*">Once Per Minute (*)</option>
								<option value="*/2">Once Per Two Minutes (*/2)</option>
								<option value="*/5">Once Per Five Minutes (*/5)</option>
								<option value="*/10">Once Per Ten Minutes (*/10)</option>
								<option value="*/15">Once Per Fifteen Minutes (*/15)</option>
								<option value="0,30">Once Per Thirty Minutes (0,30)</option>
								<option value="--">-- Minutes --</option>
								<option value="0">:00 (At the beginning of the hour.) (0)</option>
								<option value="1">:01 (1)</option>
								<option value="2">:02 (2)</option>
								<option value="3">:03 (3)</option>
								<option value="4">:04 (4)</option>
								<option value="5">:05 (5)</option>
								<option value="6">:06 (6)</option>
								<option value="7">:07 (7)</option>
								<option value="8">:08 (8)</option>
								<option value="9">:09 (9)</option>
								<option value="10">:10 (10)</option>
								<option value="11">:11 (11)</option>
								<option value="12">:12 (12)</option>
								<option value="13">:13 (13)</option>
								<option value="14">:14 (14)</option>
								<option value="15">:15 (At one quarter past the hour.) (15)</option>
								<option value="16">:16 (16)</option>
								<option value="17">:17 (17)</option>
								<option value="18">:18 (18)</option>
								<option value="19">:19 (19)</option>
								<option value="20">:20 (20)</option>
								<option value="21">:21 (21)</option>
								<option value="22">:22 (22)</option>
								<option value="23">:23 (23)</option>
								<option value="24">:24 (24)</option>
								<option value="25">:25 (25)</option>
								<option value="26">:26 (26)</option>
								<option value="27">:27 (27)</option>
								<option value="28">:28 (28)</option>
								<option value="29">:29 (29)</option>
								<option value="30">:30 (At half past the hour.) (30)</option>
								<option value="31">:31 (31)</option>
								<option value="32">:32 (32)</option>
								<option value="33">:33 (33)</option>
								<option value="34">:34 (34)</option>
								<option value="35">:35 (35)</option>
								<option value="36">:36 (36)</option>
								<option value="37">:37 (37)</option>
								<option value="38">:38 (38)</option>
								<option value="39">:39 (39)</option>
								<option value="40">:40 (40)</option>
								<option value="41">:41 (41)</option>
								<option value="42">:42 (42)</option>
								<option value="43">:43 (43)</option>
								<option value="44">:44 (44)</option>
								<option value="45">:45 (At one quarter until the hour.) (45)</option>
								<option value="46">:46 (46)</option>
								<option value="47">:47 (47)</option>
								<option value="48">:48 (48)</option>
								<option value="49">:49 (49)</option>
								<option value="50">:50 (50)</option>
								<option value="51">:51 (51)</option>
								<option value="52">:52 (52)</option>
								<option value="53">:53 (53)</option>
								<option value="54">:54 (54)</option>
								<option value="55">:55 (55)</option>
								<option value="56">:56 (56)</option>
								<option value="57">:57 (57)</option>
								<option value="58">:58 (58)</option>
								<option value="59">:59 (59)</option>
							</select>
						</div>
					</div>
					
					<div class="form-group" >
						<label class="control-label col-md-2" >Hour</label>
						<div class="col-md-2" >
							<input type="text" class="form-control input-sm" name="hour">
						</div>
						<div class="col-md-6" >
							<select class="form-control input-sm options" data-type="hour" >
								<option value="--">-- Common Settings --</option>
								<option value="*">Every Hour (*)</option>
								<option value="*/2">Every Other Hour (*/2)</option>
								<option value="*/3">Every Third Hour (*/3)</option>
								<option value="*/4">Every Fourth Hour (*/4)</option>
								<option value="*/6">Every Sixth Hour (*/6)</option>
								<option value="0,12">Every Twelve Hours (0,12)</option>
								<option value="--">-- Hours --</option>
								<option value="0">12:00 a.m. Midnight (0)</option>
								<option value="1">1:00 a.m. (1)</option>
								<option value="2">2:00 a.m. (2)</option>
								<option value="3">3:00 a.m. (3)</option>
								<option value="4">4:00 a.m. (4)</option>
								<option value="5">5:00 a.m. (5)</option>
								<option value="6">6:00 a.m. (6)</option>
								<option value="7">7:00 a.m. (7)</option>
								<option value="8">8:00 a.m. (8)</option>
								<option value="9">9:00 a.m. (9)</option>
								<option value="10">10:00 a.m. (10)</option>
								<option value="11">11:00 a.m. (11)</option>
								<option value="12">12:00 p.m. Noon (12)</option>
								<option value="13">1:00 p.m. (13)</option>
								<option value="14">2:00 p.m. (14)</option>
								<option value="15">3:00 p.m. (15)</option>
								<option value="16">4:00 p.m. (16)</option>
								<option value="17">5:00 p.m. (17)</option>
								<option value="18">6:00 p.m. (18)</option>
								<option value="19">7:00 p.m. (19)</option>
								<option value="20">8:00 p.m. (20)</option>
								<option value="21">9:00 p.m. (21)</option>
								<option value="22">10:00 p.m. (22)</option>
								<option value="23">11:00 p.m. (23)</option>
							</select>
						</div>
					</div>
					
					<div class="form-group" >
						<label class="control-label col-md-2" >Day</label>
						<div class="col-md-2" >
							<input type="text" class="form-control input-sm" name="day">
						</div>
						<div class="col-md-6" >
							<select class="form-control input-sm options" data-type="day" >
								<option value="--">-- Common Settings --</option>
								<option value="*">Every Day (*)</option>
								<option value="*/2">Every Other Day (*/2)</option>
								<option value="1,15">On the 1st and 15th of the Month (1,15)</option>
								<option value="--">-- Days --</option>
								<option value="1">1st (1)</option>
								<option value="2">2nd (2)</option>
								<option value="3">3rd (3)</option>
								<option value="4">4th (4)</option>
								<option value="5">5th (5)</option>
								<option value="6">6th (6)</option>
								<option value="7">7th (7)</option>
								<option value="8">8th (8)</option>
								<option value="9">9th (9)</option>
								<option value="10">10th (10)</option>
								<option value="11">11th (11)</option>
								<option value="12">12th (12)</option>
								<option value="13">13th (13)</option>
								<option value="14">14th (14)</option>
								<option value="15">15th (15)</option>
								<option value="16">16th (16)</option>
								<option value="17">17th (17)</option>
								<option value="18">18th (18)</option>
								<option value="19">19th (19)</option>
								<option value="20">20th (20)</option>
								<option value="21">21st (21)</option>
								<option value="22">22nd (22)</option>
								<option value="23">23rd (23)</option>
								<option value="24">24th (24)</option>
								<option value="25">25th (25)</option>
								<option value="26">26th (26)</option>
								<option value="27">27th (27)</option>
								<option value="28">28th (28)</option>
								<option value="29">29th (29)</option>
								<option value="30">30th (30)</option>
								<option value="31">31st (31)</option>
							</select>
						</div>
					</div>
					
					<div class="form-group" >
						<label class="control-label col-md-2" >Month</label>
						<div class="col-md-2" >
							<input type="text" class="form-control input-sm" name="month">
						</div>
						<div class="col-md-6" >
							<select class="form-control input-sm options" data-type="month" >
								<option value="--">-- Common Settings --</option>
								<option value="*">Every Month (*)</option>
								<option value="*/2">Every Other Month (*/2)</option>
								<option value="*/4">Every Third Month (*/4)</option>
								<option value="1,7">Every Six Months (1,7)</option>
								<option value="--">-- Months --</option>
								<option value="1">January (1)</option>
								<option value="2">February (2)</option>
								<option value="3">March (3)</option>
								<option value="4">April (4)</option>
								<option value="5">May (5)</option>
								<option value="6">June (6)</option>
								<option value="7">July (7)</option>
								<option value="8">August (8)</option>
								<option value="9">September (9)</option>
								<option value="10">October (10)</option>
								<option value="11">November (11)</option>
								<option value="12">December (12)</option>
							</select>
						</div>
					</div>
					
					<div class="form-group" >
						<label class="control-label col-md-2" >Weekday</label>
						<div class="col-md-2" >
							<input type="text" class="form-control input-sm" name="weekday">
						</div>
						<div class="col-md-6" >
							<select class="form-control input-sm options" data-type="weekday" >
								<option value="--">-- Common Settings --</option>
								<option value="*">Every Day (*)</option>
								<option value="1-5">Every Weekday (1-5)</option>
								<option value="0,6">Every Weekend Day (6,0)</option>
								<option value="1,3,5">Every Monday, Wednesday, and Friday (1,3,5)</option>
								<option value="2,4">Every Tuesday and Thursday (2,4)</option>
								<option value="--">-- Weekdays --</option>
								<option value="0">Sunday (0)</option>
								<option value="1">Monday (1)</option>
								<option value="2">Tuesday (2)</option>
								<option value="3">Wednesday (3)</option>
								<option value="4">Thursday (4)</option>
								<option value="5">Friday (5)</option>
								<option value="6">Saturday (6)</option>
							</select>
						</div>
					</div>
					
					<div class="form-group" >
						<label class="control-label col-md-2" >Command</label>
						<div class="col-md-10" >
							<input type="text" class="form-control input-sm" name="command">
						</div>
					</div>
					
					

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary">Add</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>