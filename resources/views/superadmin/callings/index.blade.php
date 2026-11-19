@extends('layouts.superadmin')

@section('title', 'AI Voice Callings | Doctorwala Super Admin')

@push('styles')
<style>
    .transcript-box {
        background-color: #f8fafc;
        border-left: 4px solid var(--doc-primary);
        padding: 15px;
        border-radius: 6px;
        max-height: 350px;
        overflow-y: auto;
        font-family: inherit;
        white-space: pre-wrap;
        line-height: 1.6;
        font-size: 0.88rem;
    }
    .summary-box {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid #bae6fd;
        border-radius: 8px;
        padding: 14px 16px;
    }
    .webhook-card {
        background: #ffffff;
        border: 1px solid var(--doc-border);
        border-radius: var(--doc-radius);
    }
    .code-pill {
        background: #f1f5f9;
        color: var(--doc-primary);
        padding: 4px 8px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 0.88rem;
        border: 1px solid #e2e8f0;
    }
</style>
@endpush

@section('content')
<!-- Header Section -->
<div class="row mb-3 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-none d-sm-flex align-items-center justify-content-center rounded-circle" style="width: 46px; height: 46px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-headset fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold text-dark mb-1">
                    AI Voice Calling Leads (Riya Assistant)
                </h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Automatic calling log, provider discovery details, transcripts, recordings & Vapi webhook.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-md-right mt-3 mt-md-0">
        <a href="{{ route('superadmin.export.callings', request()->query()) }}" class="btn btn-success btn-icon-text font-weight-bold" style="background: #10b981 !important; border-color: #10b981 !important;">
            <i class="fa-solid fa-file-excel mr-1"></i> Export to Excel
        </a>
    </div>
</div>

<!-- KPIs Row -->
<div class="row mb-4">
    <div class="col-md mb-3 stretch-card">
        <div class="doc-stat-card w-100">
            <div class="doc-stat-label">Total Calls</div>
            <div class="doc-stat-val text-primary">{{ $totalCalls ?? 0 }}</div>
            <small class="text-muted"><i class="fa-solid fa-phone mr-1"></i> Inbound/Outbound</small>
        </div>
    </div>
    <div class="col-md mb-3 stretch-card">
        <div class="doc-stat-card w-100">
            <div class="doc-stat-label">Leads Captured</div>
            <div class="doc-stat-val text-success">{{ $leadsCaptured ?? 0 }}</div>
            <small class="text-muted"><i class="fa-solid fa-user-check mr-1"></i> Identified Providers</small>
        </div>
    </div>
    <div class="col-md mb-3 stretch-card">
        <div class="doc-stat-card w-100">
            <div class="doc-stat-label">Callbacks</div>
            <div class="doc-stat-val text-warning">{{ $callbacksScheduled ?? 0 }}</div>
            <small class="text-muted"><i class="fa-solid fa-clock-rotate-left mr-1"></i> Follow-up Needed</small>
        </div>
    </div>
    <div class="col-md mb-3 stretch-card">
        <div class="doc-stat-card w-100">
            <div class="doc-stat-label">Links Sent</div>
            <div class="doc-stat-val" style="color: #0d9488;">{{ $linksSent ?? 0 }}</div>
            <small class="text-muted"><i class="fa-solid fa-paper-plane mr-1"></i> WhatsApp/SMS</small>
        </div>
    </div>
    <div class="col-md mb-3 stretch-card">
        <div class="doc-stat-card w-100">
            <div class="doc-stat-label">DND Marked</div>
            <div class="doc-stat-val text-danger">{{ $dndCount ?? 0 }}</div>
            <small class="text-muted"><i class="fa-solid fa-ban mr-1"></i> Do Not Disturb</small>
        </div>
    </div>
</div>

<!-- Webhook Connection Info Banner -->
<div class="card webhook-card mb-4 shadow-sm">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center flex-wrap">
                <span class="doc-badge doc-badge-success mr-2 mb-1"><i class="fa-solid fa-bolt mr-1"></i> VAPI WEBHOOK LIVE</span>
                <span class="font-weight-bold text-dark mr-1 mb-1" style="font-size: 0.88rem;">Server URL:</span>
                <code class="code-pill mb-1" id="vapiWebhookUrl">{{ url('/api/vapi/webhook') }}</code>
            </div>
            <div class="mt-2 mt-md-0">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyWebhookUrl()">
                    <i class="fa-regular fa-copy mr-1"></i> Copy URL
                </button>
                <button class="btn btn-sm btn-outline-secondary ml-1" type="button" data-toggle="collapse" data-target="#vapiInstructions">
                    <i class="fa-solid fa-circle-question mr-1"></i> Setup Guide
                </button>
            </div>
        </div>
        <div class="collapse mt-3" id="vapiInstructions">
            <hr class="my-2">
            <div class="row text-muted" style="font-size: 0.85rem;">
                <div class="col-md-6 mb-2">
                    <strong class="text-dark">1. In Vapi AI Assistant Settings:</strong><br>
                    Go to <em>Assistant &rarr; Advanced &rarr; Server URL</em> and paste the copied URL above.<br>
                    Vapi automatically delivers call updates, tool executions, and the final <code>end-of-call-report</code>.
                </div>
                <div class="col-md-6 mb-2">
                    <strong class="text-dark">2. Intelligent Fallback:</strong><br>
                    Even if the assistant does not execute tool calls during conversation, our backend automatically extracts provider name, location, service type, and link status directly from the transcript!
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Card -->
<div class="card mb-4 shadow-sm">
    <div class="card-body py-3">
        <form action="{{ route('superadmin.super-callings') }}" method="GET">
            <div class="row align-items-end">
                <div class="col-lg-3 col-md-6 mb-2">
                    <label class="font-weight-bold text-muted small mb-1">Search</label>
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Phone, Provider, City, Doctor..." value="{{ request('search') }}">
                </div>
                <div class="col-lg-2 col-md-6 mb-2">
                    <label class="font-weight-bold text-muted small mb-1">Provider Type</label>
                    <select name="provider_type" class="form-control form-control-sm">
                        <option value="">All Types</option>
                        <option value="OPD" {{ request('provider_type') == 'OPD' ? 'selected' : '' }}>OPD</option>
                        <option value="Path" {{ request('provider_type') == 'Path' ? 'selected' : '' }}>Pathology</option>
                        <option value="Doctor" {{ request('provider_type') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                        <option value="Hospital" {{ request('provider_type') == 'Hospital' ? 'selected' : '' }}>Hospital</option>
                        <option value="Medical Shop" {{ request('provider_type') == 'Medical Shop' ? 'selected' : '' }}>Medical Shop</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4 mb-2">
                    <label class="font-weight-bold text-muted small mb-1">Status</label>
                    <select name="status" class="form-control form-control-sm">
                        <option value="">All Statuses</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="callback" {{ request('status') == 'callback' ? 'selected' : '' }}>Callback Scheduled</option>
                        <option value="link_sent" {{ request('status') == 'link_sent' ? 'selected' : '' }}>Link Sent</option>
                        <option value="dnd" {{ request('status') == 'dnd' ? 'selected' : '' }}>DND</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4 mb-2">
                    <label class="font-weight-bold text-muted small mb-1">Language</label>
                    <select name="language" class="form-control form-control-sm">
                        <option value="">All Languages</option>
                        <option value="Bengali" {{ request('language') == 'Bengali' ? 'selected' : '' }}>Bengali</option>
                        <option value="Hindi" {{ request('language') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                        <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-4 mb-2 d-flex">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill mr-1">
                        <i class="fa-solid fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('superadmin.super-callings') }}" class="btn btn-outline-secondary btn-sm flex-fill">
                        <i class="fa-solid fa-rotate-right mr-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Main Table Card -->
<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Callings Records (Table: <code class="text-primary">callings</code>)</h5>
        <span class="badge badge-light border px-3 py-1 font-weight-bold">Total: {{ $callings->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Date & Time</th>
                        <th>Phone Number</th>
                        <th>Provider Name & Type</th>
                        <th>Location</th>
                        <th>Doctors / Tests</th>
                        <th>Mode / Fees</th>
                        <th>Language</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($callings as $call)
                    <tr>
                        <td class="font-weight-bold text-muted" style="font-size: 0.85rem;">
                            {{ ($callings->currentPage() - 1) * $callings->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div class="font-weight-bold text-dark">{{ $call->created_at ? $call->created_at->format('d M Y') : 'N/A' }}</div>
                            <div class="text-muted small">{{ $call->created_at ? $call->created_at->format('h:i A') : '' }}</div>
                            @if($call->duration_seconds)
                            <span class="badge badge-light border mt-1"><i class="fa-regular fa-clock mr-1"></i>{{ $call->formatted_duration }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="font-weight-bold text-dark">{{ $call->phone_number ?? 'Unknown' }}</div>
                            <div class="mt-1 d-flex">
                                @if($call->phone_number)
                                <a href="tel:{{ $call->clean_phone }}" class="badge badge-primary mr-1" title="Call">
                                    <i class="fa fa-phone"></i> Call
                                </a>
                                <a href="https://wa.me/{{ $call->clean_phone }}" target="_blank" class="badge badge-success" title="WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i> Chat
                                </a>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="font-weight-bold text-dark" style="font-size: 0.95rem;">
                                {{ $call->provider_name ?? '— Pending Discovery —' }}
                            </div>
                            @if($call->provider_type)
                            <span class="doc-badge doc-badge-opd mt-1">{{ $call->provider_type }}</span>
                            @endif
                        </td>
                        <td>
                            @if($call->location)
                            <i class="fa-solid fa-location-dot text-danger mr-1"></i>{{ $call->location }}
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($call->doctors_and_timings)
                            <div class="small text-truncate" style="max-width: 170px;" title="{{ $call->doctors_and_timings }}">
                                <strong>Doc:</strong> {{ $call->doctors_and_timings }}
                            </div>
                            @endif
                            @if($call->tests_offered)
                            <div class="small text-truncate" style="max-width: 170px;" title="{{ $call->tests_offered }}">
                                <strong>Tests:</strong> {{ $call->tests_offered }}
                            </div>
                            @endif
                            @if(!$call->doctors_and_timings && !$call->tests_offered)
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($call->consultation_modes)
                            <span class="doc-badge doc-badge-neutral">{{ ucfirst($call->consultation_modes) }}</span><br>
                            @endif
                            @if($call->doctor_fee_known)
                            <small class="text-muted">Fee: <strong>{{ $call->doctor_fee_known }}</strong></small>
                            @endif
                            @if(!$call->consultation_modes && !$call->doctor_fee_known)
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($call->language)
                            <span class="badge badge-light border font-weight-bold">{{ $call->language }}</span>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($call->app_link_sent)
                            <span class="doc-badge doc-badge-success d-inline-block mb-1"><i class="fa fa-paper-plane mr-1"></i>Link Sent</span><br>
                            @endif
                            @if($call->callback_scheduled)
                            <span class="doc-badge doc-badge-warning d-inline-block mb-1" title="{{ $call->callback_time }}"><i class="fa fa-calendar-check mr-1"></i>Callback</span><br>
                            @endif
                            @if($call->is_dnd)
                            <span class="doc-badge doc-badge-danger d-inline-block mb-1"><i class="fa fa-ban mr-1"></i>DND</span><br>
                            @endif
                            @if(!$call->app_link_sent && !$call->callback_scheduled && !$call->is_dnd)
                            <span class="doc-badge doc-badge-neutral">{{ ucfirst($call->call_status ?? 'completed') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-icon-square" data-toggle="modal" data-target="#detailModal{{ $call->id }}" title="View Full Details">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-icon-square" data-toggle="modal" data-target="#deleteModal{{ $call->id }}" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <i class="fa-solid fa-headset fa-3x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">No Calling Records Found</h5>
                            <p class="text-muted small">Configure your Vapi AI Voice Assistant Webhook using the URL above to start receiving calls automatically into this table.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="table-pagination-footer">
            <div class="text-muted small mb-2 mb-md-0 font-weight-bold">
                Showing {{ $callings->firstItem() ?? 0 }} to {{ $callings->lastItem() ?? 0 }} of {{ $callings->total() }} entries
            </div>
            <div>
                {{ $callings->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modals Section -->
@foreach($callings as $call)
<!-- Detail Modal -->
<div class="modal fade" id="detailModal{{ $call->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: var(--doc-radius);">
            <div class="modal-header bg-white border-bottom py-3">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-headset text-primary mr-2 fa-lg"></i>
                    <h5 class="modal-title font-weight-bold text-dark">
                        Call Details: {{ $call->provider_name ?? ($call->phone_number ?? 'Call #' . $call->id) }}
                    </h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <!-- Audio Player -->
                @if($call->recording_url)
                <div class="card mb-3 border">
                    <div class="card-body py-2 px-3 bg-light d-flex align-items-center flex-wrap" style="border-radius: var(--doc-radius);">
                        <strong class="mr-3 text-primary"><i class="fa-solid fa-play-circle mr-1"></i> Call Audio Recording:</strong>
                        <audio controls style="flex-grow: 1; max-width: 100%;">
                            <source src="{{ $call->recording_url }}" type="audio/mpeg">
                            Your browser does not support audio playback.
                        </audio>
                    </div>
                </div>
                @endif

                <!-- AI Summary -->
                @if($call->summary)
                <div class="summary-box mb-3">
                    <h6 class="font-weight-bold text-primary mb-1"><i class="fa-solid fa-sparkles mr-1"></i> AI Conversation Summary</h6>
                    <p class="mb-0 text-dark" style="line-height: 1.5;">{{ $call->summary }}</p>
                </div>
                @endif

                <!-- Key Info Grid -->
                <div class="card border mb-3">
                    <div class="card-header bg-light py-2 font-weight-bold text-dark">
                        <i class="fa-solid fa-info-circle mr-1 text-primary"></i> Provider & Discovery Details
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-striped mb-0">
                            <tbody>
                                <tr>
                                    <td style="width: 35%;" class="font-weight-bold text-muted">Calling Phone Number:</td>
                                    <td>
                                        <strong class="text-dark">{{ $call->phone_number ?? 'N/A' }}</strong>
                                        @if($call->phone_number)
                                        <a href="tel:{{ $call->clean_phone }}" class="ml-2 badge badge-primary"><i class="fa fa-phone"></i> Call</a>
                                        <a href="https://wa.me/{{ $call->clean_phone }}" target="_blank" class="ml-1 badge badge-success"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Provider Name:</td>
                                    <td><strong class="text-primary">{{ $call->provider_name ?? 'Not Provided' }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Provider Type:</td>
                                    <td>{{ $call->provider_type ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Location:</td>
                                    <td>{{ $call->location ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Doctors and Timings:</td>
                                    <td>{{ $call->doctors_and_timings ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Consultation Mode:</td>
                                    <td>{{ $call->consultation_modes ? ucfirst($call->consultation_modes) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Doctor Fee:</td>
                                    <td>{{ $call->doctor_fee_known ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Tests Offered:</td>
                                    <td>{{ $call->tests_offered ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Rates List Exists:</td>
                                    <td>{{ $call->rates_list_exists ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Home Sample Collection:</td>
                                    <td>{{ $call->home_sample_collection ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Language:</td>
                                    <td>{{ $call->language ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Partner App Link Sent:</td>
                                    <td>
                                        @if($call->app_link_sent)
                                        <span class="doc-badge doc-badge-success"><i class="fa fa-check mr-1"></i> Sent via WhatsApp/SMS</span>
                                        @else
                                        <span class="doc-badge doc-badge-neutral">Not Sent</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Callback Scheduled:</td>
                                    <td>
                                        @if($call->callback_scheduled)
                                        <span class="doc-badge doc-badge-warning"><i class="fa fa-calendar-check mr-1"></i> Yes: {{ $call->callback_time }}</span>
                                        @if($call->callback_notes)
                                        <div class="small text-muted mt-1">Notes: {{ $call->callback_notes }}</div>
                                        @endif
                                        @else
                                        <span class="doc-badge doc-badge-neutral">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">Call Duration & Status:</td>
                                    <td>
                                        <span class="doc-badge doc-badge-neutral">{{ ucfirst($call->call_status ?? 'completed') }}</span>
                                        <span class="ml-2 text-muted">Duration: {{ $call->formatted_duration }}</span>
                                        @if($call->ended_reason)
                                        <span class="ml-1 text-muted">({{ $call->ended_reason }})</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($call->vapi_call_id)
                                <tr>
                                    <td class="font-weight-bold text-muted">Vapi Call ID:</td>
                                    <td><code>{{ $call->vapi_call_id }}</code></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Call Transcript -->
                @if($call->transcript)
                <div class="mb-3">
                    <h6 class="font-weight-bold text-dark mb-2">
                        <i class="fa-solid fa-comment-dots mr-1 text-primary"></i> Call Transcript
                    </h6>
                    <div class="transcript-box">{{ $call->transcript }}</div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $call->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: var(--doc-radius);">
            <form action="{{ route('superadmin.super-callings.delete', $call->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mb-3 mx-auto rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold">Delete Calling Record?</h5>
                    <p class="text-muted">Are you sure you want to delete call record #{{ $call->id }} ({{ $call->phone_number ?? 'No Number' }})? This action cannot be undone.</p>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="button" class="btn btn-light mr-2" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger font-weight-bold" style="background: #ef4444 !important; border-color: #ef4444 !important;">Confirm Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
    function copyWebhookUrl() {
        var url = document.getElementById('vapiWebhookUrl').innerText;
        navigator.clipboard.writeText(url).then(function() {
            alert('Webhook URL copied to clipboard: ' + url);
        }).catch(function(err) {
            console.error('Could not copy: ', err);
        });
    }
</script>
@endpush
