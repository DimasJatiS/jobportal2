@component('mail::message')
# Terima Kasih Telah Melamar

Halo {{ $application->user->name }},

Terima kasih telah melamar posisi:

**{{ $application->job->title }}**  
di **{{ $application->job->company }}**

Lamaran Anda sudah kami terima dan akan diproses oleh tim HR kami.  
Silakan menunggu informasi lebih lanjut melalui email ini.

@component('mail::panel')
Tanggal Lamaran: {{ $application->created_at->format('d M Y H:i') }}  
Status Saat Ini: {{ $application->status }}
@endcomponent

Terima kasih,  
{{ config('app.name') }}
@endcomponent
