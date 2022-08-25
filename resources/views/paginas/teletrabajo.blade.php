@extends('master')

@section('css')
<style>
    /* body, html, #meet {
        margin: 0;
        overflow-x: hidden; 
        overflow-y: hidden;
        height: 100vh;
        width: 100vw;
        background-color: black;
    } */
    /* #meet{
        background-color: #f5f5f5;
        height: 100vh;
        width: 100vw;
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
    } */
</style>
@endsection
@section('content')
    <div id="meet"></div>
@endsection

@section('javascript')
<script src='https://meet.jit.si/external_api.js'></script>
  <script>
            const domainServer = "meet.jit.si";
            const roomName = "mireunion";
            const options = {
                roomName: roomName,
                height: screen.height-330,
                parentNode: document.querySelector('#meet'),
                devices: {
                    audioInput: '<deviceLabel>',
                    audioOutput: '<deviceLabel>',
                    videoInput: '<deviceLabel>'
                },
                interfaceConfigOverwrite: {
                    TOOLBAR_BUTTONS: [
                        'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                        'fodeviceselection', 'profile', 'etherpad', 'settings', 'hangup',
                        'videoquality', 'filmstrip', 'feedback', 'stats', 'shortcuts',
                        'tileview', 'download', 'help', 'mute-everyone', 'e2ee', 'security',
                        'chat',
                        'raisehand',
                    ],
                    SHOW_JITSI_WATERMARK: false
                }
            };
            const api = new JitsiMeetExternalAPI(domainServer, options);
            // Video conferencia clinte/médico inicada
            api.addEventListener('participantJoined', res => {
            })
            // Finalizar la video conferencia
            api.addEventListener('videoConferenceLeft', res => {
            });
  </script>
@endsection