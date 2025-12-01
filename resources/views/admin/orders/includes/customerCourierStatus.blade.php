
@if($status)
<div style="padding: 10px;border: 1px solid #43a047;border-radius: 5px;">
    <div style="padding: 5px;">
        <h3>Customer Success Rate</h3>
        <div class="progress">
          <div class="progress-bar" role="progressbar" style="width: {{ $status['success_rate'] }}%;" aria-valuenow="{{ $status['success_rate'] }}" aria-valuemin="0" aria-valuemax="100">
            {{ $status['success_rate'] }}%
          </div>
        </div>
    </div>
    <div class="status" style="display: flex;">
        <div style="width: 33.33%;border-radius: 5px;padding: 10px 15px;margin: 5px;background: #fef1e4;text-align: center;">
            <span>Processed</span><br>
            <b>{{ $status['processed'] }}</b>
        </div>
        <div style="width: 33.33%;padding: 10px 15px;border-radius: 5px;margin: 5px;background: #dcf5de;text-align: center;">
            <span>Delivered</span><br>
            <b>{{ $status['delivered'] }}</b>
        </div>
        <div style="width: 33.33%;border-radius: 5px;padding: 5px 15px;margin: 5px;background: #f5f8fa;text-align: center;">
            <span>Returned</span><br>
            <b>{{ $status['returned'] }}</b>
        </div>
    </div>
</div>
@else
<p style="color: red;text-align: center;">No Courier Record Found</p>
@endif