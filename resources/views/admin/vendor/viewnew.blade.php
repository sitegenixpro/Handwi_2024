@extends('admin.template.layout')

@section('content')
<style>
    /* Ensure all cards have equal height */
    .card-body {
        min-height: 200px; /* Adjust this value to fit your design */
    }

    /* Add some spacing between table cells */
    table.table-bordered th, table.table-bordered td {
        vertical-align: middle;
        text-align: left;
    }

    /* If you want to make the columns equal size */
    .col-md-6 {
        display: flex;
        flex-direction: column;
    }

    .col-md-6 .card {
        flex: 1;
    }

    /* Optional: Add some padding inside each card */
    .card {
        padding: 1rem;
    }
</style>
<div class="container mt-4">
    <div class="row">
        
        <!-- Vendor Information Card -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Vendor Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="w-25">Name</th>
                            <td>{{ optional($vendor)->first_name ?: 'N/A' }} </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ optional($vendor)->email ?: 'N/A' }}</td>
                        </tr>
                        <!-- <tr>
                            <th>Phone</th>
                            <td>{{ $vendor->phone ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{ $vendor->country_id ? 'Country Name' : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $vendor->active == 1 ? 'Active' : 'Inactive' }}</td>
                        </tr> -->
                        <tr>
                            <th>Status</th>
                            <td>{{ optional($vendor)->verified == 1 ? 'Active' : 'Inactive' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- Survey Topics Card -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Survey Topics</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        @forelse($surveyTopics as $topic)
                        <tr>
                            <td>{{ $topic->topic }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td>No Survey Topics Available</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>

        <!-- Help Topics Card -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Selected Topics</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        @forelse($helpTopics as $topic)
                        <tr>
                            <td>{{ $topic->topic }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td>No Help Topics Available</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>

        <!-- Vendor Details Card -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Shop Preferences</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="w-25">Language</th>
                            <td>{{ optional($storeDetails)->shop_language ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                           <td> @if($storeDetails && $storeDetails->country_id)
                                    {{ optional(\App\Models\CountryModel::find($storeDetails->country_id))->name ?? 'Country not found' }}
                                @else
                                    N/A
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <th>Currency</th>
                            <td>{{ $storeDetails->shop_currency ?? 'N/A' }}</td>
                        </tr>
                       
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Name of shop</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="w-25">Store Name</th>
                            <td>{{ optional($storeDetails)->store_name ?? 'NA'}}</td>
                        </tr>
                        <tr>
                            <th>Logo</th>
                           <td> 
                            @if(optional($storeDetails)->logo)
                                    <img src="{{ asset('storage/' . $storeDetails->logo) }}" alt="Store Logo" style="max-width: 150px; max-height: 150px;"/>
                                @else
                                    No logo available
                                @endif
                                
                            </td>
                        </tr>
                        <tr>
                           <th class="w-25">Description</th>
                            <td style="word-wrap: break-word; max-width: 300px; overflow: hidden; text-overflow: ellipsis;">
                                {{ optional($storeDetails)->description ?? 'No description available' }}
                            </td>
                        </tr>
                       
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Get Paid</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="w-25">Bank Located</th>
                            <td>
                               @if($storeDetails && $storeDetails->bank_country)
                                    {{ optional(\App\Models\CountryModel::find($storeDetails->bank_country))->name ?? 'Country not found' }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Seller type</th>
                          
                           <td>@if (optional($storeDetails)->tax_seller_type == 1)
                                    Individual
                                @elseif (optional($storeDetails)->tax_seller_type == 2)
                                    Business
                                @else
                                    N/A
                                @endif
                            </td>
                                
                            
                        </tr>
                        <tr>
                           <th >Country Residence</th>
                            <td >
                                
                                @if($storeDetails && $storeDetails->residence_country)
                                    {{ optional(\App\Models\CountryModel::find($storeDetails->residence_country))->name ?? 'Country not found' }}
                                @else
                                    N/A
                                @endif
                            
                            </td>
                        </tr>
                        <tr>
                           <th >First Name</th>
                            <td >
                            {{ optional($storeDetails)->first_name ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                           <th >Last Name</th>
                            <td >
                            {{ optional($storeDetails)->last_name ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                           <th >DoB</th>
                            <td >
                                @if(isset($storeDetails->dob_day, $storeDetails->dob_month, $storeDetails->dob_year))
                                    {{ $storeDetails->dob_day }}-{{ $storeDetails->dob_month }}-{{ $storeDetails->dob_year }}
                                @else
                                    No DoB available
                                @endif
                            </td>
                        </tr>
                       
                       
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Tax Payer Address</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="w-25">Number</th>
                            <td>{{ optional($storeDetails)->tax_number ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Street name</th>
                        
                           <td>{{ optional($storeDetails)->tax_street ?: 'N/A' }}</td>
                                
                           
                        </tr>
                        <tr>
                           <th >Address line 2</th>
                            <td >
                            {{ optional($storeDetails)->tax_address_line_2 ?: 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                           <th >City/Town</th>
                           <td >
                            {{ optional($storeDetails)->tax_city ?: 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                           <th >State/Province/Region</th>
                            <td >
                            {{ optional($storeDetails)->tax_state ?: 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                           <th >Postal Code</th>
                            <td >
                            {{ optional($storeDetails)->tax_post_code ?: 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                           <th >Phone number</th>
                            <td >
                            {{ optional($storeDetails)->tax_phone ?: 'N/A' }}
                            </td>
                        </tr>
                       
                    </table>
                </div>
            </div>
        </div>

        <!-- Bank Details Card -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Bank Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Bank Name</th>
                            <td>{{ optional($bankDetails)->bank_name ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Account Number</th>
                            <td>{{ optional($bankDetails)->company_account ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>IBAN</th>
                            <td>{{ optional($bankDetails)->iban ?: 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Billing Address</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="w-25">Country</th>
                            <td>
                            @if($vendorDetails && $vendorDetails->country)
                                    {{ optional(\App\Models\CountryModel::find($vendorDetails->country))->name ?? 'Country not found' }}
                                @else
                                    N/A
                                @endif
                                 </td>
                        </tr>
                        <tr>
                            <th>Street address</th>
                           
                           <td>{{ optional($vendorDetails)->street1 ?: 'N/A' }}</td>
                                
                            
                        </tr>
                        <tr>
                            <th>Address line 2</th>
                           
                           <td>{{ optional($vendorDetails)->street2 ?: 'N/A' }}</td>
                                
                            
                        </tr>
                       
                        <tr>
                           <th >City/Town</th>
                            <td >
                            @if($vendorDetails && $vendorDetails->city)
                                    {{ optional(\App\Models\Cities::find($vendorDetails->city))->name ?? 'City not found' }}
                                @else
                                    N/A
                                @endif
                            
                            </td>
                        </tr>
                        <tr>
                           <th >State/Province/Region</th>
                            <td >
                            @if($vendorDetails && $vendorDetails->state)
                                    {{ optional(\App\Models\States::find($vendorDetails->state))->name ?? 'State not found' }}
                                @else
                                    N/A
                                @endif
                           
                            </td>
                        </tr>
                        <tr>
                           <th >Postal Code</th>
                            <td >
                            {{ optional($vendorDetails)->postal_code ?: 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                           <th >Phone number</th>
                            <td >
                            {{ optional($vendorDetails)->phone_number ?: 'N/A' }}
                            </td>
                        </tr>
                       
                    </table>
                </div>
            </div>
        </div>

        <!-- Store Details Card -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Shop Security</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th> Two-factor authentication (2FA)</th>
                            <td>{{ optional($vendor)->two_factor_auth ?: 'N/A' }}</td>
                        </tr>
                        
                       
                    </table>
                </div>
            </div>
        </div>

        

    </div>
</div>

@endsection

@section('script')
    <!-- Additional scripts can go here -->
@endsection
