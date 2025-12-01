<!-- Modal -->
 <div class="modal fade text-left" id="payment">
   <div class="modal-dialog" role="document">
	 <div class="modal-content">
	   <div class="modal-header">
		 <h4 class="modal-title">Payment</h4>
		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		   <span aria-hidden="true">&times; </span>
		 </button>
	   </div>
	   <div class="modal-body">
	   		<ul class="nav nav-tabs" role="tablist" style="border-bottom: none;">
				<li class="nav-item">
					<a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" role="tab" aria-selected="true"> Received Payment</a>
				</li>
			</ul>
			<div class="tab-content px-1 pt-1" style="border: 1px solid #ddd;">
				<div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
    				<form action="{{route('admin.ordersAction',['payment',$order->id])}}" method="post">
    					@csrf
    					<input type="hidden" value="0" name="transaction_type">
    					<div class="form-group">
    					    <label>Payment Date</label>
    					    <input type="date" value="{{$order->created_at->format('Y-m-d')}}" class="form-control" name="created_at">
    					</div>
    					<div class="form-group">
    						<label>Amount</label>
    						<input type="number" class="form-control PayAmount" step="any" name="amount" placeholder="Enter Amount" value="{{$order->due_amount?:''}}">
    					</div>
    					<div class="form-group">
    						<label>Method</label>
    						<div class="input-group">
    						<select class="form-control" name="method" required="">
    							<option value="">Select Method</option>
    						@foreach($methods as $method)
    							<option value="{{$method->id}}" >{{$method->name}}</option>
    							@endforeach
    						</select>
    						</div>
    					</div>
    					<div class="form-group">
    						<label>Note</label>
    						<textarea name="note" class="form-control" placeholder="Write Note.."></textarea>
    					</div>
    					<div class="input-group input-group-sm" style="width: 250px;margin:5px 0;">
    					<!--@if(general()->sms_status)-->
    					<!--	<label style="cursor: pointer;padding: 0 5px;"><input type="checkbox" name="mail_sms"> Send SMS</label>-->
    					<!--@endif-->
    					<!--@if(general()->mail_status)-->
    					<!--	<label style="cursor: pointer;padding: 0 5px;"><input type="checkbox" name="mail_send"> Send Mail</label>-->
    					<!--@endif-->
    					</div>
    					<button type="submit" class="btn btn-primary">Submit</button>
    					<br>
    				</form>
				</div>
            </div>
	   </div>
	 </div>
   </div>
 </div>