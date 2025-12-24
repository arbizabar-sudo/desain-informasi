@extends('layout')

@section('content')
<div style="padding:20px">
    <h2>Debug: Simulate Notification</h2>
    <p>This page simulates artwork actions by writing to <code>localStorage</code> and dispatching the <code>artwork-action</code> event so you can test the sidebar notification panel across tabs.</p>

    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <label>Owner (username): <input id="ownerInput" value="{{ auth()->check() ? auth()->user()->username : 'owner' }}" style="margin-left:6px"></label>
        <label>Owner ID: <input id="ownerIdInput" value="{{ auth()->check() ? auth()->id() : '' }}" style="margin-left:6px"></label>
        <label>Actor (username): <input id="actorInput" value="tester" style="margin-left:6px"></label>
        <label>Action:
            <select id="actionSelect" style="margin-left:6px">
                <option value="like">like</option>
                <option value="save">save</option>
                <option value="share">share</option>
            </select>
        </label>
        <label>Title: <input id="titleInput" value="Test Artwork" style="margin-left:6px"></label>
    </div>

    <div style="margin-top:12px; display:flex; gap:8px">
        <button id="sendBtn" class="btn">Send Notification</button>
        <button id="clearBtn" class="btn" type="button" style="background:#eee">Clear Stored Notifications</button>
    </div>

    <div style="margin-top:12px; color:#666">Open another tab with the app (as the owner user), then click <em>Send Notification</em> to see the sidebar update in the other tab.</div>
</div>

<script>
    document.getElementById('sendBtn').addEventListener('click', function(){
        const owner = document.getElementById('ownerInput').value || null;
        const ownerId = document.getElementById('ownerIdInput').value || null;
        const actor = document.getElementById('actorInput').value || null;
        const action = document.getElementById('actionSelect').value || 'like';
        const title = document.getElementById('titleInput').value || null;
        const payload = { id: 'debug-'+Date.now(), owner, owner_id: ownerId, actor, action, title, t: Date.now() };
        localStorage.setItem('artwork-action', JSON.stringify(payload));
        try { window.dispatchEvent(new CustomEvent('artwork-action', { detail: payload })); } catch(e){}
        setTimeout(()=> localStorage.removeItem('artwork-action'), 800);
        alert('Simulated: ' + JSON.stringify(payload));
    });
    document.getElementById('clearBtn').addEventListener('click', function(){ localStorage.removeItem('notifications'); localStorage.setItem('notifications_unseen', '0'); alert('Cleared stored notifications'); });
</script>
@endsection