@extends('web.master')
@section('title','www.kulega.com')
@section('content')

<style media="screen">
  .kt-voice-msg-wrapper{
    background: url('https://www.ketto.org/images/voice_message/voice-msg-bg.png') center 0 no-repeat;
    background-size: cover;
    background-attachment: fixed;
    margin-top: -17px;
    color: #fff;
  }

  .kt-voice-msg-wrapper .voice-msg-overlay{
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,.7);
  }

  .kt-voice-msg-wrapper .voice-msg-overlay .subscription-steps .kt-subscribe{
    list-style: none;
    padding-left: 0;
  }

  .turn-life-around{
    color: #fff;
  }

  .nxt-screen{
    background-color: #fcbb56;
    border-color: #fcbb56;
  }
</style>

<div class="kt-voice-msg-wrapper">
	<div class="voice-msg-overlay">
		<div class="container" style="padding-top: 5%;padding-bottom: 2%;">
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<div class="row">
						<div class="col-xs-12" style="margin-bottom:10%;">
							<img src="https://www.ketto.org/images/voice_message/ketto-voice.png" class="img img-responsive kt-voice-logo">
						</div>
						<div class="col-xs-offset-2 col-xs-10 hidden-xs" style="margin-bottom:10%;">
							<img src="https://www.ketto.org/images/voice_message/kt-whasapp-no.png" class="img img-responsive kt-whatsapp-no">
						</div>
					</div>
				</div>
				<div class="col-md-8 col-sm-8">
					<!-- First Step START -->
					<div class="subscription-steps">
						<div class="row">
							<div class="col-md-11">
								<h2 class="turn-life-around">A simple WhatsApp share can turn someone's life around completely.</h2>
								<p class="voice-subscribe">
								Subscribe to 'Voice' our WhatsApp channel and get stories of people who need nothing more than your voice, a share.<br>
Click the below Subscribe button and just send us "Hi Ketto, please subscribe me for Ketto Voice." to start receiving Stories.
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-10">
								<form action="" method="POST" id="frm_voice_message">
									<ul class="kt-subscribe">
										<!--<li class="contact-no">
											<div class="control-group">
												<input type="hidden" name="form_action" value="SEND">
												<input type="tel" id="phone" name="fmd_contact_no" class="form-control input-lg" placeholder="Mobile Number" required/>
												<span id="invalidNo" class="error-block hidden"></span>
												<div id="valid-msg" class="hide"><em>✓ Thank you</em></div>
												<div id="error-msg" class="hide error-block">Please enter a valid number</div>
											</div>
										</li>-->
										<li class="contact-submit pull-left">
											<a href="https://api.whatsapp.com/send?phone=918291379122&amp;text=Count%20me%20in%21%20I%20want%20to%20subscribe%20to%20Ketto%20Voice." target="_blank"><button type="button" class="nxt-screen btn btn-primary btn-lg text-uppercase">subscribe</button></a>
										</li>
									</ul>
								</form>
							</div>
						</div>
					</div>
					<!-- First Step END -->

					<div class="row voice-general-info">
						<div class="col-md-12" style="margin-top:6%;">
							<p>
								<span><strong>Unsubscribe: </strong></span>
								<span>If you wish to terminate the service, send 'Stop' via Whatsapp and we will stop sending you stories within 24-48 hours.</span>
							</p>
							<p>
								<span><strong>Disclaimer: </strong></span>
								<span>By subscribing to this free service, you indemnify Ketto from any damages that may occur via this service. Ketto and its owners will not be held liable for any adverse impact that this service may lead to.</span>
							</p>
							<p>
								<span><strong>Contact: </strong></span>
								<span>In case you have any queries, please email us at <a href="mailto:info@ketto.org">info@ketto.org</a> Due to the large number of emails received, we may not be able to reply to every query sent, but we shall certainly look into the urgent &amp; important ones. </span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@push('js')


@endpush

@endsection
