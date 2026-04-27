{{-- resources/views/schedules/index.blade.php --}}
@extends('layouts.app')

@section('title', __('schedule.schedule'))
@section('page-title', __('schedule.schedule'))

@push('styles')
<style>
    /* ── Page header ── */
    .page-header {
        margin-bottom: 2rem;
    }
    .page-header h1 {
        font-family: 'Syne', sans-serif;
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        background: linear-gradient(135deg, #fff 30%, var(--blue-300));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.35rem;
    }
    .page-header p {
        color: var(--muted);
        font-size: 0.9rem;
    }

    /* ── Alert banners ── */
    .alert {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1.25rem;
        border-radius: 14px;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        animation: fadeUp 0.4s cubic-bezier(0.22,1,0.36,1) both;
    }
    .alert-success {
        background: rgba(34, 197, 94, 0.10);
        border: 1px solid rgba(34, 197, 94, 0.25);
        color: #4ade80;
    }
    .alert-error {
        background: rgba(239, 68, 68, 0.10);
        border: 1px solid rgba(239, 68, 68, 0.25);
        color: #f87171;
    }

    /* ── Upload zone ── */
    .upload-zone {
        border: 2px dashed rgba(55, 138, 221, 0.3);
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.02);
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.25s, background 0.25s, transform 0.2s;
        position: relative;
        overflow: hidden;
    }
    .upload-zone::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 50% at 50% 0%, rgba(55, 138, 221, 0.06), transparent);
        pointer-events: none;
    }
    .upload-zone:hover,
    .upload-zone.drag-over {
        border-color: rgba(55, 138, 221, 0.65);
        background: rgba(55, 138, 221, 0.05);
        transform: translateY(-2px);
    }
    .upload-zone.drag-over {
        border-color: var(--accent);
        background: rgba(56, 189, 248, 0.07);
    }

    .upload-icon-wrap {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(55, 138, 221, 0.18), rgba(56, 189, 248, 0.1));
        border: 1px solid rgba(55, 138, 221, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        box-shadow: 0 8px 24px rgba(55, 138, 221, 0.15);
        transition: transform 0.25s, box-shadow 0.25s;
    }
    .upload-zone:hover .upload-icon-wrap {
        transform: scale(1.08);
        box-shadow: 0 12px 32px rgba(55, 138, 221, 0.25);
    }
    .upload-icon-wrap svg { color: var(--blue-400); }

    .upload-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 0.4rem;
    }
    .upload-subtitle {
        color: var(--muted);
        font-size: 0.85rem;
        line-height: 1.5;
        margin-bottom: 1.5rem;
    }
    .upload-subtitle span { color: var(--blue-400); font-weight: 500; }

    .format-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
    .format-pdf {
        background: rgba(239, 68, 68, 0.1);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    #realFileInput { display: none; }

    /* ── Title input ── */
    .title-field-wrap {
        margin-bottom: 1.5rem;
    }
    .title-label {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: var(--blue-300);
        margin-bottom: 0.5rem;
    }
    .title-label svg { opacity: 0.75; }
    .title-input {
        width: 100%;
        padding: 0.7rem 1rem;
        border-radius: 12px;
        background: rgba(255,255,255,0.04);
        border: 1px solid var(--border);
        color: var(--white);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem;
        transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .title-input::placeholder { color: var(--muted); }
    .title-input:focus {
        border-color: rgba(55,138,221,0.5);
        background: rgba(55,138,221,0.05);
        box-shadow: 0 0 0 3px rgba(55,138,221,0.1);
    }
    .title-input.is-invalid {
        border-color: rgba(239,68,68,0.5);
        background: rgba(239,68,68,0.04);
    }
    .field-error {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: 0.45rem;
        font-size: 0.78rem;
        color: #f87171;
    }

    /* ── Upload button ── */
    .btn-upload {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.5rem;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--blue-600), var(--blue-700));
        border: 1px solid rgba(55, 138, 221, 0.35);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
        box-shadow: 0 6px 20px rgba(24, 95, 165, 0.35);
    }
    .btn-upload:hover {
        background: linear-gradient(135deg, var(--blue-500), var(--blue-600));
        box-shadow: 0 10px 28px rgba(24, 95, 165, 0.5);
        transform: translateY(-1px);
    }
    .btn-upload:active { transform: translateY(0); }
    .btn-upload:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

    /* ── File info bar ── */
    .file-info-bar {
        display: none;
        align-items: center;
        gap: 1rem;
        padding: 0.9rem 1.25rem;
        background: rgba(55, 138, 221, 0.07);
        border: 1px solid rgba(55, 138, 221, 0.2);
        border-radius: 14px;
        margin-top: 1.5rem;
        animation: fadeUp 0.4s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .file-info-bar.visible { display: flex; }

    .file-icon-box {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        background: rgba(239,68,68,0.12);
        border: 1px solid rgba(239,68,68,0.2);
        color: #f87171;
    }
    .file-meta { flex: 1; min-width: 0; }
    .file-name {
        font-size: 0.9rem; font-weight: 600; color: var(--white);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .file-size { font-size: 0.75rem; color: var(--muted); margin-top: 1px; }

    .file-actions { display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0; }
    .btn-change {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.45rem 0.9rem; border-radius: 9px;
        background: rgba(55,138,221,0.12); border: 1px solid rgba(55,138,221,0.25);
        color: var(--blue-300); font-size: 0.8rem; font-weight: 600; cursor: pointer;
        transition: background 0.2s, border-color 0.2s;
    }
    .btn-change:hover { background: rgba(55,138,221,0.2); border-color: rgba(55,138,221,0.4); }
    .btn-remove {
        display: inline-flex; align-items: center; justify-content: center;
        width: 34px; height: 34px; border-radius: 9px;
        background: rgba(248,113,113,0.08); border: 1px solid rgba(248,113,113,0.18);
        color: #f87171; cursor: pointer; transition: background 0.2s, border-color 0.2s;
    }
    .btn-remove:hover { background: rgba(248,113,113,0.18); border-color: rgba(248,113,113,0.35); }

    /* ── Submit row ── */
    .submit-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1.75rem;
        flex-wrap: wrap;
    }
    .submit-note {
        font-size: 0.78rem;
        color: var(--muted);
    }
    .submit-note span { color: var(--blue-300); font-weight: 500; }

    /* ── No-preview hint ── */
    .no-preview-hint {
        margin-top: 1.75rem;
        padding: 1.5rem;
        border-radius: 14px;
        background: rgba(55, 138, 221, 0.04);
        border: 1px dashed rgba(55, 138, 221, 0.15);
        text-align: center;
        color: rgba(156, 163, 175, 0.6);
        font-size: 0.82rem;
    }
    .no-preview-hint svg {
        display: block; margin: 0 auto 0.5rem; opacity: 0.3;
    }

    /* ── Preview section ── */
    .preview-section {
        display: none;
        margin-top: 2rem;
        animation: fadeUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .preview-section.visible { display: block; }
    .preview-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;
    }
    .preview-label {
        display: flex; align-items: center; gap: 0.5rem;
        font-family: 'Syne', sans-serif; font-size: 0.95rem;
        font-weight: 700; color: var(--white);
    }
    .preview-label svg { color: var(--blue-400); }
    .preview-wrapper {
        border-radius: 18px; border: 1px solid var(--border);
        overflow: hidden; background: rgba(255,255,255,0.02);
        box-shadow: 0 20px 60px rgba(1,26,56,0.5);
    }
    .pdf-frame {
        width: 100%; height: 75vh; min-height: 500px;
        border: none; display: block;
    }

    /* ── Upload card wrapper ── */
    .upload-card { padding: 1.75rem; }

    /* ── Responsive ── */
    @media (max-width: 600px) {
        .upload-zone { padding: 2rem 1.25rem; }
        .pdf-frame { height: 55vh; min-height: 350px; }
        .btn-change span { display: none; }
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    .schedule-list {
        margin-top: 1.25rem;
    }
    .schedule-list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 0.9rem 1rem;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: rgba(255,255,255,0.02);
    }
    .schedule-list-item + .schedule-list-item {
        margin-top: 0.75rem;
    }
    .schedule-title {
        color: var(--white);
        font-weight: 700;
        margin-bottom: 0.1rem;
    }
    .schedule-meta {
        color: var(--muted);
        font-size: 0.8rem;
    }
    .schedule-open-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.45rem 0.85rem;
        border-radius: 10px;
        border: 1px solid rgba(55, 138, 221, 0.3);
        color: var(--blue-300);
        background: rgba(55, 138, 221, 0.08);
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 700;
    }
    .schedule-open-btn:hover {
        background: rgba(55, 138, 221, 0.16);
    }

    .schedule-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
    }
    .schedule-open-btn.small {
        padding: 0.35rem 0.6rem;
        font-size: 0.8rem;
    }

    /* ── Premium Schedule List (Admin/Formateur) ── */
    .schedule-shell {
        display: grid;
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .schedule-hero {
        position: relative;
        padding: 1.5rem;
        border-radius: 18px;
        border: 1px solid rgba(55, 138, 221, 0.24);
        background:
            radial-gradient(140% 140% at 10% 20%, rgba(56, 189, 248, 0.2), rgba(1,26,56,0) 50%),
            radial-gradient(140% 140% at 90% 80%, rgba(55, 138, 221, 0.18), rgba(1,26,56,0) 50%),
            linear-gradient(135deg, rgba(9,22,43,0.95), rgba(13,33,60,0.9));
        overflow: hidden;
    }

    .schedule-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(180px circle at 100% 0%, rgba(56,189,248,0.1), transparent),
            radial-gradient(200px circle at 0% 100%, rgba(55,138,221,0.08), transparent);
        pointer-events: none;
    }

    .schedule-hero-badge {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 0.35rem 0.75rem;
        border-radius: 99px;
        background: rgba(56, 189, 248, 0.12);
        color: var(--blue-300);
        border: 1px solid rgba(56, 189, 248, 0.25);
        margin-bottom: 0.5rem;
    }

    .schedule-hero-title {
        position: relative;
        z-index: 1;
        font-family: 'Syne', sans-serif;
        font-size: 1.35rem;
        font-weight: 900;
        color: var(--white);
        margin: 0 0 0.35rem;
        line-height: 1.2;
    }

    .schedule-hero-sub {
        position: relative;
        z-index: 1;
        color: var(--muted);
        font-size: 0.88rem;
        margin: 0;
        max-width: 520px;
    }

    .schedule-metrics-row {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.8rem;
        margin-top: 1rem;
    }

    @media (max-width: 700px) {
        .schedule-metrics-row {
            grid-template-columns: 1fr;
        }
    }

    /* ── Grid of schedule cards ── */
    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    @media (max-width: 900px) {
        .schedule-grid {
            grid-template-columns: 1fr;
        }
    }

    .schedule-card {
        overflow: hidden;
        border-radius: 16px;
        border: 1px solid var(--border);
        background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
        transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
        display: flex;
        flex-direction: column;
    }

    .schedule-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(1,26,56,0.35);
        border-color: rgba(55, 138, 221, 0.35);
    }

    .schedule-card-header {
        padding: 1.1rem;
        border-bottom: 1px solid rgba(148,163,184,0.15);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .schedule-card-title {
        color: var(--white);
        font-size: 0.95rem;
        font-weight: 700;
        margin: 0;
        word-break: break-word;
        flex: 1;
    }

    .schedule-card-date {
        color: var(--muted);
        font-size: 0.75rem;
        white-space: nowrap;
        margin-left: 0.5rem;
    }

    .schedule-card-body {
        padding: 0.9rem 1.1rem;
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        flex: 1;
    }

    .schedule-card-btn {
        flex: 1;
        min-width: 80px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
        padding: 0.45rem 0.65rem;
        border-radius: 10px;
        border: none;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 180ms ease;
        text-decoration: none;
        text-align: center;
    }

    .schedule-card-btn-view {
        background: rgba(55, 138, 221, 0.12);
        color: var(--blue-300);
        border: 1px solid rgba(55, 138, 221, 0.25);
    }
    .schedule-card-btn-view:hover {
        background: rgba(55, 138, 221, 0.22);
        border-color: rgba(55, 138, 221, 0.4);
    }

    .schedule-card-btn-edit {
        background: rgba(99, 102, 241, 0.12);
        color: #a5b4fc;
        border: 1px solid rgba(99, 102, 241, 0.25);
    }
    .schedule-card-btn-edit:hover {
        background: rgba(99, 102, 241, 0.22);
        border-color: rgba(99, 102, 241, 0.4);
    }

    .schedule-card-btn-delete {
        background: rgba(239, 68, 68, 0.08);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    .schedule-card-btn-delete:hover {
        background: rgba(239, 68, 68, 0.16);
        border-color: rgba(239, 68, 68, 0.35);
    }

    .schedule-card-btn-download {
        background: rgba(34, 197, 94, 0.08);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }
    .schedule-card-btn-download:hover {
        background: rgba(34, 197, 94, 0.16);
        border-color: rgba(34, 197, 94, 0.35);
    }

    /* ── Inline delete confirmation ── */
    .delete-confirm-strip {
        display: none;
        align-items: center;
        gap: 0.6rem;
        padding: 0.7rem 1.1rem;
        background: rgba(239, 68, 68, 0.07);
        border-top: 1px solid rgba(239, 68, 68, 0.18);
        animation: fadeUp 0.18s cubic-bezier(0.22,1,0.36,1) both;
    }
    .delete-confirm-strip.visible {
        display: flex;
    }
    .delete-confirm-strip span {
        flex: 1;
        font-size: 0.8rem;
        color: #f87171;
    }
    .btn-confirm-yes {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.38rem 0.85rem;
        border-radius: 8px;
        background: rgba(239, 68, 68, 0.14);
        border: 1px solid rgba(239, 68, 68, 0.35);
        color: #f87171;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.15s, border-color 0.15s;
    }
    .btn-confirm-yes:hover {
        background: rgba(239, 68, 68, 0.25);
        border-color: rgba(239, 68, 68, 0.55);
    }
    .btn-confirm-no {
        display: inline-flex;
        align-items: center;
        padding: 0.38rem 0.85rem;
        border-radius: 8px;
        background: rgba(148, 163, 184, 0.08);
        border: 1px solid rgba(148, 163, 184, 0.2);
        color: var(--muted);
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.15s;
    }
    .btn-confirm-no:hover {
        background: rgba(148, 163, 184, 0.16);
    }

    /* ── Student view delete confirm (inline in actions row) ── */
    .student-delete-confirm {
        display: none;
        align-items: center;
        gap: 0.45rem;
        padding: 0.4rem 0.7rem;
        border-radius: 10px;
        background: rgba(239, 68, 68, 0.07);
        border: 1px solid rgba(239, 68, 68, 0.2);
        animation: fadeUp 0.18s cubic-bezier(0.22,1,0.36,1) both;
    }
    .student-delete-confirm.visible {
        display: flex;
    }
    .student-delete-confirm span {
        font-size: 0.75rem;
        color: #f87171;
        white-space: nowrap;
    }

    /* ── Inline edit form in card ── */
    .schedule-card-edit-form {
        padding: 0.9rem 1.1rem;
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        border-top: 1px solid rgba(148,163,184,0.15);
    }
    .schedule-card-edit-form input {
        flex: 1;
        min-width: 140px;
        padding: 0.5rem 0.8rem;
        border-radius: 10px;
        border: 1px solid rgba(55, 138, 221, 0.3);
        background: rgba(55, 138, 221, 0.05);
        color: var(--white);
        font-size: 0.85rem;
        font-family: inherit;
        outline: none;
        transition: border-color 180ms, background 180ms;
    }
    .schedule-card-edit-form input:focus {
        border-color: rgba(55, 138, 221, 0.6);
        background: rgba(55, 138, 221, 0.1);
    }
    .schedule-card-edit-form button {
        padding: 0.45rem 0.8rem;
        border-radius: 10px;
        border: none;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 180ms ease;
    }
    .schedule-card-edit-form .btn-save {
        background: rgba(34, 197, 94, 0.12);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.25);
    }
    .schedule-card-edit-form .btn-save:hover {
        background: rgba(34, 197, 94, 0.22);
        border-color: rgba(34, 197, 94, 0.4);
    }
    .schedule-card-edit-form .btn-cancel {
        background: rgba(148, 163, 184, 0.1);
        color: var(--muted);
        border: 1px solid rgba(148, 163, 184, 0.2);
    }
    .schedule-card-edit-form .btn-cancel:hover {
        background: rgba(148, 163, 184, 0.2);
        border-color: rgba(148, 163, 184, 0.35);
    }

    .student-shell {
        display: grid;
        gap: 1.2rem;
        margin-top: 1.1rem;
    }
    .student-hero {
        position: relative;
        padding: 1.35rem;
        border-radius: 18px;
        border: 1px solid rgba(55, 138, 221, 0.24);
        background:
            radial-gradient(120% 120% at 0% 0%, rgba(56,189,248,0.18) 0%, rgba(1,26,56,0) 45%),
            radial-gradient(120% 120% at 100% 100%, rgba(55,138,221,0.2) 0%, rgba(1,26,56,0) 50%),
            linear-gradient(150deg, rgba(9,22,43,0.95), rgba(13,33,60,0.9));
        overflow: hidden;
    }
    .student-hero::after {
        content: '';
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        right: -60px;
        top: -60px;
        background: radial-gradient(circle, rgba(56,189,248,0.22), rgba(56,189,248,0));
        pointer-events: none;
    }
    .student-eyebrow {
        margin: 0;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--blue-300);
        font-weight: 700;
    }
    .student-title {
        margin: 0.35rem 0 0;
        font-family: 'Syne', sans-serif;
        font-size: clamp(1.05rem, 2.2vw, 1.35rem);
        color: var(--white);
        font-weight: 800;
        line-height: 1.2;
    }
    .student-sub {
        margin: 0.45rem 0 0;
        color: var(--muted);
        font-size: 0.86rem;
    }
    .student-metrics {
        margin-top: 0.95rem;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.7rem;
    }
    .metric-card {
        border: 1px solid rgba(148, 163, 184, 0.22);
        border-radius: 12px;
        background: rgba(255,255,255,0.04);
        padding: 0.85rem 0.9rem;
    }
    .metric-label {
        color: var(--muted);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        font-weight: 700;
    }
    .metric-value {
        margin-top: 0.2rem;
        color: var(--white);
        font-size: 1.02rem;
        font-weight: 800;
    }
    .metric-value.ok { color: #4ade80; }
    .metric-value.off { color: #f87171; }

    .student-board {
        border-radius: 16px;
        border: 1px solid var(--border);
        background: rgba(255,255,255,0.03);
        padding: 1rem;
    }
    .student-board-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
    }
    .student-board-title {
        margin: 0;
        color: var(--white);
        font-size: 0.98rem;
        font-family: 'Syne', sans-serif;
        letter-spacing: 0.01em;
    }
    .student-board-count {
        font-size: 0.73rem;
        color: var(--blue-300);
        border: 1px solid rgba(55, 138, 221, 0.3);
        border-radius: 99px;
        padding: 0.22rem 0.6rem;
        font-weight: 700;
    }
    .student-schedule-item {
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 0.8rem;
        align-items: center;
        border: 1px solid rgba(148,163,184,0.2);
        border-radius: 12px;
        padding: 0.78rem 0.8rem;
        background: linear-gradient(145deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
    }
    .student-schedule-item + .student-schedule-item {
        margin-top: 0.65rem;
    }
    .schedule-index-chip {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        border: 1px solid rgba(55, 138, 221, 0.35);
        background: rgba(55, 138, 221, 0.16);
        color: var(--blue-300);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.76rem;
        font-weight: 800;
    }

    @media (max-width: 760px) {
        .student-metrics {
            grid-template-columns: 1fr;
        }
        .student-schedule-item {
            grid-template-columns: 1fr;
            gap: 0.65rem;
        }
        .schedule-index-chip {
            display: none;
        }
    }
</style>
@endpush

@section('content')

{{-- ── Flash messages ── --}}
@if (session('success'))
    <div class="alert alert-success anim">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

@if ($errors->any() && ! $errors->has('title') && ! $errors->has('file'))
    <div class="alert alert-error anim">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        {{ __('messages.something_wrong') }}. {{ __('messages.try_again') }}.
    </div>
@endif

{{-- ── Page Header ── --}}
<div class="page-header anim">
    <h1>{{ __('schedule.schedule_title') }}</h1>
    <p>
        {{ in_array(auth()->user()->role, ['admin', 'formateur'], true) ? __('schedule.upload_hint') : 'Track your attendance and access your weekly learning files.' }}
    </p>
</div>

@if(auth()->user()->role === 'student')
    <div class="student-shell anim">
        <section class="student-hero">
            <p class="student-eyebrow">Student workspace</p>
            <h2 class="student-title">Your Learning Schedule</h2>
            <p class="student-sub">All your uploaded sessions in one place with your attendance visibility.</p>

            <div class="student-metrics">
                <div class="metric-card">
                    <div class="metric-label">Attendance status</div>
                    <div class="metric-value {{ $myPresence && $myPresence->statut === 'present' ? 'ok' : 'off' }}">
                        {{ $myPresence ? ucfirst($myPresence->statut) : 'Not set yet' }}
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-label">Available schedules</div>
                    <div class="metric-value">{{ $schedules->count() }}</div>
                </div>
            </div>
        </section>

        <section class="student-board">
            <div class="student-board-head">
                <h3 class="student-board-title">Weekly Files</h3>
                <span class="student-board-count">{{ $schedules->count() }} files</span>
            </div>

            @forelse($schedules as $item)
                <article class="student-schedule-item">
                    <div class="schedule-index-chip">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    <div>
                        <div class="schedule-title">{{ $item->title }}</div>
                        <div class="schedule-meta">Uploaded {{ $item->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="schedule-actions">
                        <a class="schedule-open-btn small" href="{{ asset('storage/' . $item->file_path) }}" target="_blank" rel="noopener noreferrer">
                            {{ __('messages.view') }}
                        </a>
                        <a class="schedule-open-btn small" href="{{ asset('storage/' . $item->file_path) }}" download="{{ $item->title }}.pdf" rel="noopener noreferrer">
                            {{ __('messages.download') }}
                        </a>

                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'formateur'], true))
                            <button type="button" class="schedule-edit-btn small" data-id="{{ $item->id }}">{{ __('messages.edit') }}</button>

                            {{-- Delete trigger button --}}
                            <button
                                type="button"
                                class="schedule-open-btn small"
                                style="color:#f87171;border-color:rgba(239,68,68,0.3);background:rgba(239,68,68,0.08);"
                                onclick="toggleStudentDelete({{ $item->id }}, this)"
                            >{{ __('messages.delete') }}</button>

                            {{-- Inline confirmation (student list view) --}}
                            <div class="student-delete-confirm" id="studentDeleteConfirm-{{ $item->id }}">
                                <span>Sure?</span>
                                <form method="POST" action="{{ route('schedules.destroy', $item->id) }}" style="display:contents;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-confirm-yes" style="padding:0.28rem 0.65rem;font-size:0.72rem;">Yes</button>
                                </form>
                                <button
                                    type="button"
                                    class="btn-confirm-no"
                                    style="padding:0.28rem 0.65rem;font-size:0.72rem;"
                                    onclick="toggleStudentDelete({{ $item->id }}, null)"
                                >No</button>
                            </div>

                            <form method="POST" action="{{ route('schedules.update', $item->id) }}" class="schedule-edit-form" id="editForm-{{ $item->id }}" style="display:none;margin-top:0.5rem;">
                                @csrf
                                @method('PUT')
                                <input type="text" name="title" value="{{ $item->title }}" class="title-input small" required style="margin-right:0.5rem;">
                                <button type="submit" class="schedule-open-btn small">{{ __('messages.save') }}</button>
                                <button type="button" class="schedule-cancel-edit small" data-id="{{ $item->id }}">{{ __('messages.cancel') }}</button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <p style="margin:0;color:var(--muted);">No schedules uploaded yet.</p>
            @endforelse
        </section>
    </div>
@else
    <div class="schedule-shell anim anim-d1">
        <section class="schedule-hero">
            <span class="schedule-hero-badge">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Manage Schedules
            </span>
            <h2 class="schedule-hero-title">Available Schedules</h2>
            <p class="schedule-hero-sub">View, edit, and manage all uploaded learning schedules. Download files or update their titles to keep everything organized.</p>

            <div class="schedule-metrics-row">
                <div class="metric-card">
                    <div class="metric-label">Total uploaded</div>
                    <div class="metric-value">{{ $schedules->count() }}</div>
                </div>
                <div class="metric-card">
                    <div class="metric-label">Last updated</div>
                    <div class="metric-value">{{ $schedules->count() > 0 ? $schedules->first()->created_at->format('M d') : '—' }}</div>
                </div>
            </div>
        </section>

        <section class="schedule-grid">
        @forelse($schedules as $item)
            <article class="schedule-card">
                <div class="schedule-card-header">
                    <h3 class="schedule-card-title">{{ $item->title }}</h3>
                    <time class="schedule-card-date">{{ $item->created_at->format('M d, Y') }}</time>
                </div>

                <div class="schedule-card-body">
                    <a class="schedule-card-btn schedule-card-btn-view" href="{{ asset('storage/' . $item->file_path) }}" target="_blank" rel="noopener noreferrer">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        View
                    </a>
                    <a class="schedule-card-btn schedule-card-btn-download" href="{{ asset('storage/' . $item->file_path) }}" download="{{ $item->title }}.pdf" rel="noopener noreferrer">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        Download
                    </a>
                    <button type="button" class="schedule-card-btn schedule-card-btn-edit" data-id="{{ $item->id }}">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Edit
                    </button>

                    {{-- Delete trigger — no confirm(), opens the strip below --}}
                    <button
                        type="button"
                        class="schedule-card-btn schedule-card-btn-delete"
                        onclick="toggleDeleteConfirm({{ $item->id }}, this)"
                    >
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2l-1-14"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                        </svg>
                        Delete
                    </button>
                </div>

                {{-- Inline delete confirmation strip --}}
                <div class="delete-confirm-strip" id="deleteConfirm-{{ $item->id }}">
                    <span>Delete this schedule? This can't be undone.</span>
                    <form method="POST" action="{{ route('schedules.destroy', $item->id) }}" style="display:contents;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-confirm-yes">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Yes, delete
                        </button>
                    </form>
                    <button
                        type="button"
                        class="btn-confirm-no"
                        onclick="toggleDeleteConfirm({{ $item->id }}, null)"
                    >Cancel</button>
                </div>

                {{-- Inline edit form --}}
                <form method="POST" action="{{ route('schedules.update', $item->id) }}" class="schedule-card-edit-form" id="editForm-{{ $item->id }}" style="display:none;">
                    @csrf
                    @method('PUT')
                    <input type="text" name="title" value="{{ $item->title }}" required placeholder="New title">
                    <button type="submit" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel schedule-cancel-edit-card" data-id="{{ $item->id }}">Cancel</button>
                </form>
            </article>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 2rem 1rem; color: var(--muted);">
                <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="opacity: 0.3; margin: 0 auto 0.75rem; display: block;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
                <p style="margin: 0;">No schedules uploaded yet. Start by uploading a new schedule below.</p>
            </div>
        @endforelse
        </section>
    </div>
@endif

@if(in_array(auth()->user()->role, ['admin', 'formateur'], true))
{{-- ── Upload Form Card ── --}}
<div class="card upload-card anim anim-d1">
    <form
        id="uploadForm"
        method="POST"
        action="{{ route('schedules.upload') }}"
        enctype="multipart/form-data"
        novalidate
    >
        @csrf

        {{-- Title field --}}
        <div class="title-field-wrap">
            <label class="title-label" for="title">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="21" y1="6" x2="3" y2="6"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                    <line x1="17" y1="18" x2="3" y2="18"/>
                </svg>
                {{ __('schedule.schedule_title_label') }}
            </label>
            <input
                type="text"
                id="title"
                name="title"
                class="title-input @error('title') is-invalid @enderror"
                placeholder="{{ __('schedule.schedule_title_placeholder') }}"
                value="{{ old('title') }}"
                autocomplete="off"
                required
            >
            @error('title')
                <div class="field-error">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Drop zone --}}
        <div
            class="upload-zone @error('file') drag-over @enderror"
            id="dropZone"
            onclick="document.getElementById('realFileInput').click()"
        >
            <div class="upload-icon-wrap">
                <svg width="30" height="30" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
            </div>
            <div class="upload-title">{{ __('schedule.drop_pdf') }}</div>
            <div class="upload-subtitle">
                {{ __('schedule.drag_drop') }} <span>{{ __('schedule.click_browse') }}</span>
            </div>
            <span class="format-tag format-pdf" style="margin-bottom:1.25rem;display:inline-flex;">
                <svg width="11" height="11" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                </svg>
                {{ __('schedule.pdf_only_max') }}
            </span>
            <input
                type="file"
                id="realFileInput"
                name="file"
                accept=".pdf,application/pdf"
            >
        </div>

        @error('file')
            <div class="field-error" style="margin-top:0.5rem;">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ $message }}
            </div>
        @enderror

        {{-- File info bar --}}
        <div class="file-info-bar" id="fileInfoBar">
            <div class="file-icon-box">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div class="file-meta">
                <div class="file-name" id="chosenFileName">–</div>
                <div class="file-size" id="chosenFileSize">–</div>
            </div>
            <div class="file-actions">
                <button
                    type="button"
                    class="btn-change"
                    onclick="document.getElementById('realFileInput').click()"
                >
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    <span>{{ __('messages.edit') }}</span>
                </button>
                <button type="button" class="btn-remove" id="removeFileBtn" title="{{ __('messages.delete') }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- No-preview hint --}}
        <div class="no-preview-hint" id="noPreviewHint">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
            {{ __('schedule.preview_hint') }}
        </div>

        {{-- Submit row --}}
        <div class="submit-row">
            <button type="submit" class="btn-upload" id="submitBtn">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                {{ __('schedule.upload_schedule') }}
            </button>
            <span class="submit-note">
                {{ __('schedule.stored_in') }} <span>storage/app/public/schedules/</span>
            </span>
        </div>

    </form>
</div>

{{-- PDF preview --}}
<div class="preview-section" id="previewSection">
    <div class="preview-header">
        <div class="preview-label">
            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            {{ __('messages.view') }}
        </div>
        <span class="format-tag format-pdf">{{ __('schedule.pdf_document') }}</span>
    </div>
    <div class="preview-wrapper">
        <iframe id="pdfFrame" class="pdf-frame" title="PDF preview"></iframe>
    </div>
</div>
@endif

@endsection

@push('scripts')
@if(in_array(auth()->user()->role, ['admin', 'formateur'], true))
<script>
    /* ── Element refs ── */
    const dropZone      = document.getElementById('dropZone');
    const fileInput     = document.getElementById('realFileInput');
    const fileInfoBar   = document.getElementById('fileInfoBar');
    const chosenName    = document.getElementById('chosenFileName');
    const chosenSize    = document.getElementById('chosenFileSize');
    const noHint        = document.getElementById('noPreviewHint');
    const previewSec    = document.getElementById('previewSection');
    const pdfFrame      = document.getElementById('pdfFrame');
    const removeBtn     = document.getElementById('removeFileBtn');
    const submitBtn     = document.getElementById('submitBtn');
    let   objectUrl     = null;

    /* ── Drag & Drop ── */
    ['dragenter', 'dragover'].forEach(evt =>
        dropZone.addEventListener(evt, e => {
            e.preventDefault();
            dropZone.classList.add('drag-over');
        })
    );
    ['dragleave', 'drop'].forEach(evt =>
        dropZone.addEventListener(evt, e => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
        })
    );
    dropZone.addEventListener('drop', e => {
        const file = e.dataTransfer.files[0];
        if (file) attachFile(file);
    });

    /* ── File input change ── */
    fileInput.addEventListener('change', () => {
        if (fileInput.files[0]) attachFile(fileInput.files[0]);
    });

    /* ── Remove button ── */
    removeBtn.addEventListener('click', clearFile);

    /* ── Helpers ── */
    function formatBytes(bytes) {
        if (bytes < 1024)    return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    function attachFile(file) {
        if (file.type !== 'application/pdf') {
            alert('{{ __('schedule.only_pdf_allowed') }}');
            return;
        }
        if (objectUrl) URL.revokeObjectURL(objectUrl);
        objectUrl = URL.createObjectURL(file);
        chosenName.textContent = file.name;
        chosenSize.textContent = formatBytes(file.size);
        fileInfoBar.classList.add('visible');
        noHint.style.display = 'none';
        pdfFrame.src = objectUrl;
        previewSec.classList.add('visible');
        setTimeout(() => previewSec.scrollIntoView({ behavior: 'smooth', block: 'start' }), 120);
    }

    function clearFile() {
        fileInput.value = '';
        if (objectUrl) { URL.revokeObjectURL(objectUrl); objectUrl = null; }
        pdfFrame.src = '';
        fileInfoBar.classList.remove('visible');
        previewSec.classList.remove('visible');
        noHint.style.display = '';
    }

    /* ── Submitting state ── */
    document.getElementById('uploadForm').addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5"
                 style="animation:spin 0.8s linear infinite">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            {{ __('schedule.uploading') }}
        `;
    });

    /* ── Inline delete confirm — card grid (admin/formateur) ── */
    function toggleDeleteConfirm(id, triggerBtn) {
        // Close any other open confirm strips first
        document.querySelectorAll('.delete-confirm-strip.visible').forEach(el => {
            if (el.id !== 'deleteConfirm-' + id) {
                el.classList.remove('visible');
            }
        });
        const strip = document.getElementById('deleteConfirm-' + id);
        if (!strip) return;
        strip.classList.toggle('visible');
    }

    /* ── Inline delete confirm — student list view ── */
    function toggleStudentDelete(id, triggerBtn) {
        // Close any other open confirms first
        document.querySelectorAll('.student-delete-confirm.visible').forEach(el => {
            if (el.id !== 'studentDeleteConfirm-' + id) {
                el.classList.remove('visible');
            }
        });
        const box = document.getElementById('studentDeleteConfirm-' + id);
        if (!box) return;
        box.classList.toggle('visible');
    }

    /* ── Edit toggle — student list view ── */
    document.querySelectorAll('.schedule-edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const form = document.getElementById('editForm-' + id);
            if (!form) return;
            const open = form.style.display === 'flex' || form.style.display === 'block';
            form.style.display = open ? 'none' : 'flex';
            if (!open) {
                const input = form.querySelector('input[name="title"]');
                if (input) input.focus();
            }
        });
    });

    document.querySelectorAll('.schedule-cancel-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const form = document.getElementById('editForm-' + id);
            if (form) form.style.display = 'none';
        });
    });

    /* ── Edit toggle — card grid (admin/formateur) ── */
    document.querySelectorAll('.schedule-card-btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const form = document.getElementById('editForm-' + id);
            if (!form) return;
            const open = form.style.display === 'flex';
            form.style.display = open ? 'none' : 'flex';
            if (!open) {
                const input = form.querySelector('input[name="title"]');
                if (input) input.focus();
            }
        });
    });

    document.querySelectorAll('.schedule-cancel-edit-card').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const form = document.getElementById('editForm-' + id);
            if (form) form.style.display = 'none';
        });
    });
</script>
@endif
@endpush