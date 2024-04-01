const LeadStatus = {
    processing: 'processing',
    on_hold: 'on_hold',
    new_customer: 'new_customer',
    rejected: 'rejected',
};

const LeadStatusSelectable = [
    {
        id: "processing",
        name: "Processing",
    },
    {
        id: "on_hold",
        name: "On Hold",
    },
    {
        id: "new_customer",
        name: "New Customer",
    },
    {
        id: "rejected",
        name: "Rejected",
    }
];

export { LeadStatus as default, LeadStatusSelectable }