function formatDatesToAMPM(dates) {

        const dateObj = new Date(dates);
        const options = { hour: 'numeric', minute: 'numeric', hour12: true };
        return dateObj.toLocaleString('en-US', options);

}
