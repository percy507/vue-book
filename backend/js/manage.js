(function() {
    let whichWay = document.querySelector('.which-way');

    let chooseScan = document.querySelector('.choose-scan');
    let chooseManual = document.querySelector('.choose-manual');
    let scanBook = document.querySelector('.scan-add-book');
    let manualBook = document.querySelector('.manual-add-book');

    let switchWay = document.querySelector('.switch-way');
    let scan = document.getElementById('scan');
    let manual = document.getElementById('manual');

    chooseScan.onclick = function() {
        whichWay.classList.add('hidden');
        scanBook.classList.remove('hidden');
        switchWay.classList.remove('hidden');
        startScan();
    };

    chooseManual.onclick = function() {
        whichWay.classList.add('hidden');
        manualBook.classList.remove('hidden');
        switchWay.classList.remove('hidden');
    };

    scan.onclick = function() {
        scanBook.classList.remove('hidden');
        manualBook.classList.add('hidden');
        startScan();
    };

    manual.onclick = function() {
        scanBook.classList.add('hidden');
        manualBook.classList.remove('hidden');
    };
})();