<style>

/* =========================================================
   DATA PAGE
========================================================= */

.data-page {
    width: 100%;
}


/* =========================================================
   ALERT
========================================================= */

.alert-success,
.alert-error {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 14px 18px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-success {
    background: #ecfdf3;
    color: #15803d;
    border: 1px solid #bbf7d0;
}

.alert-error {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.alert-error ul {
    margin: 6px 0 0 20px;
    padding: 0;
}


/* =========================================================
   SUMMARY CARD
========================================================= */

.summary-cards {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
    margin-bottom: 25px;
}

.summary-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 22px 20px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.summary-label {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 8px;
}

.summary-value {
    font-size: 28px;
    font-weight: 700;
    color: #111827;
}


/* =========================================================
   TABLE CONTAINER
========================================================= */

.data-table-container {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}


/* =========================================================
   TOOLBAR
========================================================= */

.table-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.table-toolbar-left {
    display: flex;
    align-items: center;
}

.table-search {
    width: 280px;
    height: 40px;
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 0 13px;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    background: #ffffff;
}

.table-search i {
    color: #9ca3af;
}

.table-search input {
    width: 100%;
    border: none;
    outline: none;
    font-size: 14px;
}

.table-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-button,
.add-button {
    height: 40px;
    padding: 0 15px;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 7px;
}

.filter-button {
    background: #ffffff;
    color: #374151;
    border: 1px solid #d1d5db;
}

.filter-button:hover {
    background: #f9fafb;
}

.add-button {
    background: #2563eb;
    color: #ffffff;
    border: none;
}

.add-button:hover {
    background: #1d4ed8;
}


/* =========================================================
   FILTER
========================================================= */

.filter-box {
    display: none;
    padding: 18px 20px;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.filter-box.show {
    display: block;
}

.filter-form {
    display: flex;
    align-items: flex-end;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.filter-group label {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
}

.filter-group select {
    min-width: 180px;
    height: 38px;
    padding: 0 10px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: #ffffff;
    outline: none;
}

.filter-submit,
.filter-reset {
    height: 38px;
    padding: 0 14px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    text-decoration: none;
}

.filter-submit {
    border: none;
    background: #2563eb;
    color: #ffffff;
}

.filter-reset {
    border: 1px solid #d1d5db;
    background: #ffffff;
    color: #374151;
}


/* =========================================================
   TABLE
========================================================= */

.data-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1100px;
}

.data-table th {
    background: #f9fafb;
    color: #374151;
    font-size: 12px;
    font-weight: 700;
    text-align: left;
    padding: 14px 15px;
    border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
}

.data-table td {
    padding: 15px;
    font-size: 13px;
    color: #374151;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: #fafafa;
}


/* =========================================================
   VERIFIKASI
========================================================= */

.verifikasi {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.verifikasi-approved {
    background: #dcfce7;
    color: #15803d;
}

.verifikasi-pending {
    background: #fef3c7;
    color: #b45309;
}

.verifikasi-rejected {
    background: #fee2e2;
    color: #dc2626;
}


/* =========================================================
   FILE
========================================================= */

.file-button {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    border-radius: 6px;
    background: #eff6ff;
    color: #2563eb;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.file-button:hover {
    background: #dbeafe;
}

.no-file {
    color: #9ca3af;
    font-size: 12px;
    white-space: nowrap;
}


/* =========================================================
   COMMENT
========================================================= */

.comment-button {
    border: none;
    background: transparent;
    color: #2563eb;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    padding: 0;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.comment-button:hover {
    text-decoration: underline;
}

.no-comment {
    color: #9ca3af;
    font-size: 12px;
}


/* =========================================================
   ACTION
========================================================= */

.action-buttons {
    display: flex;
    align-items: center;
    gap: 7px;
}

.action-buttons form {
    margin: 0;
}

.action-button {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    text-decoration: none;
}

.action-button.edit {
    background: #eff6ff;
    color: #2563eb;
}

.action-button.edit:hover {
    background: #dbeafe;
}

.action-button.delete {
    background: #fef2f2;
    color: #dc2626;
}

.action-button.delete:hover {
    background: #fee2e2;
}


/* =========================================================
   EMPTY
========================================================= */

.empty-data {
    text-align: center !important;
    padding: 50px !important;
    color: #9ca3af !important;
}

.empty-data i {
    display: block;
    font-size: 35px;
    margin-bottom: 10px;
}


/* =========================================================
   FOOTER
========================================================= */

.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    font-size: 12px;
    color: #6b7280;
}

.show-data {
    display: flex;
    align-items: center;
    gap: 7px;
}

.show-data form {
    margin: 0;
}

.show-data select {
    height: 32px;
    border: 1px solid #d1d5db;
    border-radius: 5px;
    padding: 0 8px;
    outline: none;
}

.pagination {
    display: flex;
    align-items: center;
    gap: 4px;
}

.page-link {
    min-width: 30px;
    height: 30px;
    padding: 0 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid #e5e7eb;
    border-radius: 5px;
    color: #374151;
    text-decoration: none;
    background: #ffffff;
}

.page-link:hover {
    background: #f3f4f6;
}

.page-link.active {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
}


/* =========================================================
   MODAL
========================================================= */

.data-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.data-modal.show {
    display: flex;
}

.data-modal-content {
    width: 100%;
    max-width: 520px;
    max-height: 90vh;
    overflow-y: auto;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}

.comment-modal-content {
    max-width: 500px;
}

.data-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.data-modal-header h2 {
    margin: 0;
    font-size: 19px;
    color: #111827;
}

.modal-close {
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    font-size: 25px;
    color: #6b7280;
    cursor: pointer;
    border-radius: 5px;
}

.modal-close:hover {
    background: #f3f4f6;
}


/* =========================================================
   FORM
========================================================= */

.data-modal-content form {
    padding: 20px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 7px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}

.form-control-data {
    width: 100%;
    height: 42px;
    padding: 0 12px;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    outline: none;
    font-size: 13px;
    box-sizing: border-box;
}

.form-control-data:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
}

input[type="file"].form-control-data {
    height: auto;
    padding: 9px 10px;
    cursor: pointer;
}

.form-help {
    display: block;
    margin-top: 6px;
    color: #6b7280;
    font-size: 11px;
}


/* =========================================================
   STATUS INFO
========================================================= */

.status-info {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    padding: 12px;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    border-radius: 7px;
    color: #1d4ed8;
    font-size: 12px;
    line-height: 1.5;
    margin-bottom: 20px;
}

.status-info i {
    margin-top: 2px;
}


/* =========================================================
   FORM ACTION
========================================================= */

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 5px;
}

.cancel-btn,
.save-btn {
    height: 40px;
    padding: 0 16px;
    border-radius: 7px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.cancel-btn {
    border: 1px solid #d1d5db;
    background: #ffffff;
    color: #374151;
}

.cancel-btn:hover {
    background: #f9fafb;
}

.save-btn {
    border: none;
    background: #2563eb;
    color: #ffffff;
}

.save-btn:hover {
    background: #1d4ed8;
}


/* =========================================================
   COMMENT MODAL
========================================================= */

.comment-box {
    margin: 20px;
    padding: 16px;
    border-radius: 8px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.comment-box i {
    color: #2563eb;
    margin-top: 3px;
}

.comment-box p {
    margin: 0;
    color: #374151;
    font-size: 13px;
    line-height: 1.6;
    white-space: pre-wrap;
}

.comment-modal-content .form-actions {
    padding: 0 20px 20px;
}


/* =========================================================
   CURRENT FILE
========================================================= */

.current-file {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    padding: 9px 11px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    font-size: 12px;
    color: #374151;
}

.current-file i {
    color: #2563eb;
}

.current-file a {
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
}

.current-file a:hover {
    text-decoration: underline;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .summary-cards {
        grid-template-columns: repeat(3, 1fr);
    }

}


@media (max-width: 900px) {

    .summary-cards {
        grid-template-columns: 1fr;
    }

    .table-toolbar {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }

    .table-search {
        width: 100%;
    }

    .table-actions {
        justify-content: flex-end;
    }

    .table-footer {
        flex-wrap: wrap;
        gap: 15px;
    }

}

</style>