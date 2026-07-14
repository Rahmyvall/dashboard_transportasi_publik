<style>
     :root {
          --ticket-primary: #4f46e5;
          --ticket-primary-dark: #3730a3;
          --ticket-heading: #172033;
          --ticket-text: #475569;
          --ticket-muted: #94a3b8;
          --ticket-border: #e4e8f0;
          --ticket-background: #f4f7fb;
     }

     * {
          box-sizing: border-box;
     }

     .ticket-crud-page {
          min-height: 100vh;
          background:
               radial-gradient(circle at 95% 5%,
                    rgba(79, 70, 229, 0.09),
                    transparent 26%),
               var(--ticket-background);
     }

     .ticket-crud-container {
          width: 100%;
          padding: 28px;
     }

     /*
    |--------------------------------------------------------------------------
    | Header create dan edit
    |--------------------------------------------------------------------------
    */

     .crud-page-header {
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 25px;
          margin-bottom: 25px;
          border: 1px solid rgba(226, 232, 240, 0.8);
          border-radius: 22px;
          padding: 26px 28px;
          background: rgba(255, 255, 255, 0.96);
          box-shadow: 0 15px 42px rgba(15, 23, 42, 0.065);
     }

     .back-button {
          display: inline-flex;
          align-items: center;
          gap: 7px;
          margin-bottom: 16px;
          color: #64748b;
          font-size: 12px;
          font-weight: 700;
          text-decoration: none;
     }

     .back-button:hover {
          color: var(--ticket-primary);
     }

     .page-label {
          display: block;
          margin-bottom: 5px;
          color: var(--ticket-primary);
          font-size: 10px;
          font-weight: 800;
          letter-spacing: 0.1em;
          text-transform: uppercase;
     }

     .crud-page-header h1 {
          margin: 0 0 7px;
          color: var(--ticket-heading);
          font-size: clamp(27px, 4vw, 37px);
          font-weight: 800;
          letter-spacing: -0.035em;
     }

     .crud-page-header p {
          margin: 0;
          color: #7d899c;
          font-size: 13px;
          line-height: 1.7;
     }

     .header-ticket-icon {
          width: 72px;
          height: 72px;
          display: flex;
          flex: 0 0 72px;
          align-items: center;
          justify-content: center;
          border-radius: 21px;
          background: linear-gradient(135deg, #4f46e5, #7c3aed);
          color: #ffffff;
          font-size: 30px;
          box-shadow: 0 16px 32px rgba(79, 70, 229, 0.25);
     }

     .edit-header-icon {
          background: linear-gradient(135deg, #d97706, #f59e0b);
          box-shadow: 0 16px 32px rgba(217, 119, 6, 0.22);
     }

     .header-actions {
          display: flex;
          align-items: center;
          gap: 13px;
     }

     .view-detail-button {
          display: inline-flex;
          min-height: 43px;
          align-items: center;
          justify-content: center;
          gap: 8px;
          border: 1px solid #dfe4ec;
          border-radius: 12px;
          padding: 10px 16px;
          background: #ffffff;
          color: #526077;
          font-size: 12px;
          font-weight: 700;
          text-decoration: none;
     }

     .view-detail-button:hover {
          border-color: #c7cde0;
          color: var(--ticket-primary);
     }

     /*
    |--------------------------------------------------------------------------
    | Form card
    |--------------------------------------------------------------------------
    */

     .form-card,
     .detail-card {
          overflow: hidden;
          border: 1px solid rgba(226, 232, 240, 0.85);
          border-radius: 21px;
          background: #ffffff;
          box-shadow: 0 15px 42px rgba(15, 23, 42, 0.06);
     }

     .form-card-header,
     .detail-card-header {
          display: flex;
          align-items: center;
          gap: 15px;
          border-bottom: 1px solid var(--ticket-border);
          padding: 22px 24px;
          background: #fbfcfe;
     }

     .form-card-icon,
     .detail-card-icon {
          width: 48px;
          height: 48px;
          display: flex;
          flex: 0 0 48px;
          align-items: center;
          justify-content: center;
          border-radius: 15px;
          background: #eef2ff;
          color: var(--ticket-primary);
          font-size: 21px;
     }

     .payment-icon,
     .payment-detail-icon {
          background: #ecfdf5;
          color: #047857;
     }

     .form-section-number,
     .detail-card-header>div:last-child>span {
          display: block;
          margin-bottom: 3px;
          color: var(--ticket-primary);
          font-size: 9px;
          font-weight: 800;
          letter-spacing: 0.09em;
          text-transform: uppercase;
     }

     .form-card-header h2,
     .detail-card-header h2 {
          margin: 0 0 3px;
          color: var(--ticket-heading);
          font-size: 17px;
          font-weight: 800;
     }

     .form-card-header p,
     .detail-card-header p {
          margin: 0;
          color: #8b96a8;
          font-size: 11px;
     }

     .form-card-body,
     .detail-card-body {
          padding: 25px;
     }

     /*
    |--------------------------------------------------------------------------
    | Field form
    |--------------------------------------------------------------------------
    */

     .modern-label {
          display: block;
          margin-bottom: 8px;
          color: #354156;
          font-size: 12px;
          font-weight: 750;
     }

     .required-mark {
          color: #dc2626;
     }

     .modern-input-group,
     .modern-select-group {
          position: relative;
     }

     .input-icon {
          position: absolute;
          z-index: 2;
          top: 50%;
          left: 15px;
          color: #8994a7;
          font-size: 16px;
          transform: translateY(-50%);
          pointer-events: none;
     }

     .modern-input,
     .modern-select,
     .fare-input {
          width: 100%;
          min-height: 48px;
          border: 1px solid #dce2eb;
          border-radius: 12px;
          background-color: #ffffff;
          color: #273449;
          font-size: 12px;
          outline: none;
          transition: 0.2s ease;
     }

     .modern-input,
     .modern-select {
          padding: 11px 15px 11px 45px;
     }

     .modern-select {
          padding-right: 38px;
          cursor: pointer;
     }

     .modern-input:focus,
     .modern-select:focus,
     .fare-input:focus {
          border-color: #8179ec;
          box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.09);
     }

     .modern-input.is-invalid,
     .modern-select.is-invalid,
     .fare-input.is-invalid {
          border-color: #dc2626;
     }

     .fare-input-group {
          display: flex;
     }

     .fare-prefix {
          min-width: 54px;
          display: flex;
          align-items: center;
          justify-content: center;
          border: 1px solid #dce2eb;
          border-right: 0;
          border-radius: 12px 0 0 12px;
          background: #f8fafc;
          color: #64748b;
          font-size: 12px;
          font-weight: 800;
     }

     .fare-input {
          border-radius: 0 12px 12px 0;
          padding: 11px 15px;
     }

     .field-error {
          display: block;
          margin-top: 6px;
          color: #dc2626;
          font-size: 10px;
          font-weight: 600;
     }

     .field-help {
          display: block;
          margin-top: 6px;
          color: #9aa4b4;
          font-size: 9px;
     }

     /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

     .validation-alert {
          display: flex;
          align-items: flex-start;
          gap: 14px;
          margin-bottom: 24px;
          border: 1px solid #fecaca;
          border-radius: 16px;
          padding: 17px;
          background: #fef2f2;
          color: #991b1b;
     }

     .validation-icon {
          width: 42px;
          height: 42px;
          display: flex;
          flex: 0 0 42px;
          align-items: center;
          justify-content: center;
          border-radius: 12px;
          background: #ffffff;
          font-size: 19px;
     }

     .validation-alert strong {
          display: block;
          margin-bottom: 3px;
          font-size: 13px;
     }

     .validation-alert p {
          margin: 0 0 7px;
          font-size: 11px;
     }

     .validation-alert ul {
          margin: 0;
          padding-left: 17px;
          font-size: 10px;
     }

     /*
    |--------------------------------------------------------------------------
    | Sidebar form
    |--------------------------------------------------------------------------
    */

     .form-sidebar,
     .show-sidebar {
          position: sticky;
          top: 20px;
     }

     .sidebar-header,
     .system-card-header {
          display: flex;
          align-items: center;
          gap: 13px;
          border-bottom: 1px solid var(--ticket-border);
          padding: 21px 22px;
          background: linear-gradient(135deg, #312e81, #4f46e5);
          color: #ffffff;
     }

     .sidebar-header-icon {
          width: 43px;
          height: 43px;
          display: flex;
          flex: 0 0 43px;
          align-items: center;
          justify-content: center;
          border-radius: 13px;
          background: rgba(255, 255, 255, 0.14);
          font-size: 18px;
     }

     .sidebar-header h2,
     .system-card-header h2 {
          margin: 0 0 3px;
          color: #ffffff;
          font-size: 16px;
          font-weight: 800;
     }

     .sidebar-header p,
     .system-card-header p {
          margin: 0;
          color: rgba(255, 255, 255, 0.68);
          font-size: 10px;
     }

     .ticket-preview {
          border: 1px solid #e4e7f8;
          border-radius: 16px;
          margin-bottom: 17px;
          padding: 17px;
          background:
               linear-gradient(135deg,
                    rgba(79, 70, 229, 0.06),
                    rgba(124, 58, 237, 0.03));
     }

     .preview-label {
          display: block;
          margin-bottom: 4px;
          color: #8994a7;
          font-size: 9px;
          font-weight: 800;
          letter-spacing: 0.07em;
          text-transform: uppercase;
     }

     #farePreview {
          display: block;
          margin-bottom: 11px;
          color: var(--ticket-primary-dark);
          font-size: 22px;
          font-weight: 800;
     }

     .preview-status {
          display: inline-flex;
          border-radius: 999px;
          padding: 6px 10px;
          font-size: 9px;
          font-weight: 800;
     }

     .preview-paid {
          background: #dcfce7;
          color: #15803d;
     }

     .preview-refunded {
          background: #fef3c7;
          color: #a16207;
     }

     .preview-failed {
          background: #fee2e2;
          color: #b91c1c;
     }

     .information-note {
          display: flex;
          align-items: flex-start;
          gap: 10px;
          margin-bottom: 20px;
          border: 1px solid #dbeafe;
          border-radius: 14px;
          padding: 13px;
          background: #eff6ff;
          color: #1e40af;
     }

     .information-note i {
          margin-top: 2px;
     }

     .information-note p {
          margin: 0;
          font-size: 9px;
          line-height: 1.65;
     }

     .form-actions {
          display: grid;
          gap: 9px;
     }

     .submit-button,
     .cancel-form-button {
          min-height: 46px;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
          border: 0;
          border-radius: 12px;
          padding: 10px 16px;
          font-size: 11px;
          font-weight: 750;
          text-decoration: none;
          transition: 0.2s ease;
     }

     .submit-button {
          background: linear-gradient(135deg, #4f46e5, #4338ca);
          color: #ffffff;
          box-shadow: 0 11px 24px rgba(79, 70, 229, 0.22);
     }

     .submit-button:hover {
          transform: translateY(-1px);
          box-shadow: 0 14px 28px rgba(79, 70, 229, 0.28);
     }

     .submit-button:disabled {
          opacity: 0.7;
          cursor: wait;
     }

     .cancel-form-button {
          background: #eef1f5;
          color: #526077;
     }

     .cancel-form-button:hover {
          background: #e3e8ef;
          color: #334155;
     }

     /*
    |--------------------------------------------------------------------------
    | Header show
    |--------------------------------------------------------------------------
    */

     .show-page-header {
          position: relative;
          overflow: hidden;
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 24px;
          margin-bottom: 24px;
          border-radius: 24px;
          padding: 33px;
          background: linear-gradient(135deg,
                    #1e1b4b,
                    #4338ca 58%,
                    #6366f1);
          box-shadow: 0 22px 50px rgba(55, 48, 163, 0.22);
     }

     .show-page-header>div:not(.show-decoration) {
          position: relative;
          z-index: 2;
     }

     .show-back-button {
          color: rgba(255, 255, 255, 0.72);
     }

     .show-back-button:hover {
          color: #ffffff;
     }

     .show-header-label {
          display: block;
          margin-bottom: 5px;
          color: rgba(255, 255, 255, 0.65);
          font-size: 9px;
          font-weight: 800;
          letter-spacing: 0.1em;
          text-transform: uppercase;
     }

     .show-page-header h1 {
          margin: 0 0 6px;
          color: #ffffff;
          font-size: clamp(28px, 4vw, 40px);
          font-weight: 800;
          letter-spacing: -0.035em;
     }

     .show-page-header p {
          margin: 0;
          color: rgba(255, 255, 255, 0.67);
          font-size: 12px;
     }

     .show-header-actions {
          display: flex;
          align-items: center;
          gap: 10px;
     }

     .show-status {
          display: inline-flex;
          align-items: center;
          gap: 7px;
          border-radius: 999px;
          padding: 9px 13px;
          font-size: 10px;
          font-weight: 800;
     }

     .show-status span {
          width: 7px;
          height: 7px;
          border-radius: 50%;
          background: currentColor;
     }

     .show-status-paid {
          background: #dcfce7;
          color: #15803d;
     }

     .show-status-refunded {
          background: #fef3c7;
          color: #a16207;
     }

     .show-status-failed {
          background: #fee2e2;
          color: #b91c1c;
     }

     .show-edit-button {
          display: inline-flex;
          min-height: 43px;
          align-items: center;
          justify-content: center;
          gap: 8px;
          border-radius: 12px;
          padding: 10px 16px;
          background: #ffffff;
          color: var(--ticket-primary-dark);
          font-size: 11px;
          font-weight: 750;
          text-decoration: none;
     }

     .show-edit-button:hover {
          color: var(--ticket-primary-dark);
          transform: translateY(-1px);
     }

     .show-decoration {
          position: absolute;
          border-radius: 50%;
          background: rgba(255, 255, 255, 0.06);
     }

     .show-decoration-one {
          width: 210px;
          height: 210px;
          top: -105px;
          right: -35px;
     }

     .show-decoration-two {
          width: 100px;
          height: 100px;
          right: 180px;
          bottom: -60px;
     }

     .success-message {
          display: flex;
          align-items: center;
          gap: 9px;
          margin-bottom: 20px;
          border: 1px solid #bbf7d0;
          border-radius: 14px;
          padding: 13px 15px;
          background: #f0fdf4;
          color: #166534;
          font-size: 11px;
          font-weight: 650;
     }

     /*
    |--------------------------------------------------------------------------
    | Detail show
    |--------------------------------------------------------------------------
    */

     .detail-grid {
          display: grid;
          grid-template-columns: repeat(2, minmax(0, 1fr));
          gap: 24px;
     }

     .full-detail-item {
          grid-column: 1 / -1;
     }

     .detail-item {
          min-width: 0;
     }

     .detail-label,
     .payment-detail-item>span {
          display: block;
          margin-bottom: 9px;
          color: #929cad;
          font-size: 9px;
          font-weight: 800;
          letter-spacing: 0.07em;
          text-transform: uppercase;
     }

     .ticket-code-detail {
          display: flex;
          align-items: center;
          gap: 11px;
          border: 1px solid #e5e7f8;
          border-radius: 14px;
          padding: 14px 16px;
          background: #f8f7ff;
          color: var(--ticket-primary);
     }

     .ticket-code-detail strong {
          color: #312e81;
          font-size: 17px;
     }

     .detail-value {
          display: flex;
          align-items: center;
          gap: 12px;
     }

     .detail-value>i {
          width: 40px;
          height: 40px;
          display: flex;
          flex: 0 0 40px;
          align-items: center;
          justify-content: center;
          border-radius: 12px;
          background: #f1f5f9;
          color: #64748b;
          font-size: 17px;
     }

     .detail-value strong {
          display: block;
          overflow: hidden;
          color: #334155;
          font-size: 12px;
          font-weight: 750;
          text-overflow: ellipsis;
     }

     .detail-value small {
          display: block;
          margin-top: 3px;
          color: #9aa4b4;
          font-size: 9px;
     }

     .payment-detail-grid {
          display: grid;
          grid-template-columns: repeat(3, minmax(0, 1fr));
          gap: 15px;
     }

     .payment-detail-item {
          border: 1px solid #e8ebf1;
          border-radius: 15px;
          padding: 17px;
          background: #fbfcfe;
     }

     .payment-detail-item strong {
          display: flex;
          align-items: center;
          gap: 7px;
          color: #334155;
          font-size: 13px;
     }

     .fare-detail {
          background: linear-gradient(135deg,
                    #eef2ff,
                    #f5f3ff);
     }

     .fare-detail strong {
          color: var(--ticket-primary-dark);
          font-size: 19px;
     }

     /*
    |--------------------------------------------------------------------------
    | System sidebar
    |--------------------------------------------------------------------------
    */

     .system-card-header>i {
          font-size: 23px;
     }

     .system-timeline {
          padding: 23px;
     }

     .timeline-item {
          display: flex;
          align-items: flex-start;
          gap: 12px;
     }

     .timeline-dot {
          width: 11px;
          height: 11px;
          flex: 0 0 11px;
          margin-top: 3px;
          border-radius: 50%;
          background: #4f46e5;
          box-shadow: 0 0 0 5px rgba(79, 70, 229, 0.1);
     }

     .updated-dot {
          background: #0ea5e9;
          box-shadow: 0 0 0 5px rgba(14, 165, 233, 0.1);
     }

     .database-dot {
          background: #16a34a;
          box-shadow: 0 0 0 5px rgba(22, 163, 74, 0.1);
     }

     .timeline-item span:not(.timeline-dot) {
          display: block;
          margin-bottom: 3px;
          color: #939daf;
          font-size: 9px;
     }

     .timeline-item strong {
          color: #354156;
          font-size: 11px;
     }

     .timeline-line {
          width: 1px;
          height: 28px;
          margin: 5px 0 5px 5px;
          background: #e2e8f0;
     }

     .show-sidebar-actions {
          display: grid;
          gap: 9px;
          border-top: 1px solid var(--ticket-border);
          padding: 20px 22px;
     }

     .sidebar-edit-button,
     .sidebar-back-button {
          min-height: 43px;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
          border-radius: 12px;
          padding: 10px 15px;
          font-size: 10px;
          font-weight: 750;
          text-decoration: none;
     }

     .sidebar-edit-button {
          background: var(--ticket-primary);
          color: #ffffff;
     }

     .sidebar-edit-button:hover {
          background: var(--ticket-primary-dark);
          color: #ffffff;
     }

     .sidebar-back-button {
          background: #eef1f5;
          color: #526077;
     }

     .sidebar-back-button:hover {
          color: #334155;
     }

     .danger-zone {
          margin-top: 20px;
          border: 1px solid #fecaca;
          border-radius: 18px;
          padding: 18px;
          background: #fff7f7;
     }

     .danger-zone>div {
          display: flex;
          align-items: flex-start;
          gap: 10px;
          margin-bottom: 14px;
          color: #b91c1c;
     }

     .danger-zone h3 {
          margin: 0 0 3px;
          font-size: 12px;
          font-weight: 800;
     }

     .danger-zone p {
          margin: 0;
          color: #9f6b6b;
          font-size: 9px;
     }

     .danger-zone button {
          width: 100%;
          min-height: 41px;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 7px;
          border: 0;
          border-radius: 11px;
          background: #dc2626;
          color: #ffffff;
          font-size: 10px;
          font-weight: 750;
     }

     .danger-zone button:hover {
          background: #b91c1c;
     }

     /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

     @media (max-width: 991.98px) {

          .form-sidebar,
          .show-sidebar {
               position: static;
          }
     }

     @media (max-width: 767.98px) {
          .ticket-crud-container {
               padding: 18px 14px;
          }

          .crud-page-header,
          .show-page-header {
               flex-direction: column;
               align-items: flex-start;
               border-radius: 18px;
               padding: 22px 19px;
          }

          .header-actions,
          .show-header-actions {
               width: 100%;
               flex-direction: column;
               align-items: stretch;
          }

          .view-detail-button,
          .show-edit-button {
               width: 100%;
          }

          .header-ticket-icon {
               display: none;
          }

          .form-card-body,
          .detail-card-body {
               padding: 20px 17px;
          }

          .form-card-header,
          .detail-card-header {
               padding: 19px 17px;
          }

          .detail-grid,
          .payment-detail-grid {
               grid-template-columns: 1fr;
          }

          .full-detail-item {
               grid-column: auto;
          }
     }
</style>
