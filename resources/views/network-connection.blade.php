@extends('layouts.app')

@section('content')


  <div class="container">
    <x-dashboard />
    <div class="row justify-content-center mt-5">
  <div class="col-12">
    <div class="card shadow  text-white bg-dark">
      <div class="card-header">Coding Challenge - Network connections</div>
      <div class="card-body">
        <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
          <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
          <label class="btn btn-outline-primary a_reset" for="btnradio1" id="get_suggestions_btn" on-click="">
			 <router-link  :to="{ name: 'Suggestions' }" >
		                Suggestions
		             ()</router-link></label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
          <label class="btn btn-outline-primary a_reset" for="btnradio2" id="get_sent_requests_btn">
					<router-link  :to="{ name: 'Sent requests' }" >
			    		Sent requests
		             ()
					 </router-link>
					</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
          <label class="btn btn-outline-primary a_reset" for="btnradio3" id="get_received_requests_btn">
		  <router-link  :to="{ name: 'Received requests' }" >
			    		Received requests
		            </router-link>()</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
          <label class="btn btn-outline-primary a_reset" for="btnradio4" id="get_connections_btn">
			<router-link  :to="{ name: 'Connections' }" >
			    		Connections
		             ()</router-link></label>
        </div>
        <hr>
        <div id="content" >
			<router-view/>
        </div>
      </div>
    </div>
	 <loader 
	      :is-visible="isLoading"
	  ></loader>
  </div>
</div>

  </div>
@endsection
<!-- 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
        	<ul class="nav nav-tabs">
			  <li class="nav-item">
			    <a class="nav-link" aria-current="page">
			    	<router-link  :to="{ name: 'Suggestions' }" >
		                Suggestions
		            </router-link>
			    </a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link">
			    	<router-link  :to="{ name: 'Sent requests' }" >
			    		Sent requests
		            </router-link>
			    </a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" href="#">
			    	<router-link  :to="{ name: 'Received requests' }" >
			    		Received requests
		            </router-link>
			    </a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" href="#">
			    	<router-link  :to="{ name: 'Connections' }" >
			    		Connections
		            </router-link>
			    </a>
			  </li>
			</ul>
             <router-link  :to="{ name: 'Network Connections' }" >
              <p>
                Network Connections
              </p>
            </router-link>
            <div class="mt-3">
            	<router-view/>
            </div>
        </div>
    </div>
    <loader 
	      :is-visible="isLoading"
	  ></loader>
</div>
 -->
