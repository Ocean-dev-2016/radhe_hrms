<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="assets/vendor/libs/popper/popper.js"></script>
<script src="assets/vendor/js/bootstrap.js"></script>
<script src="assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="assets/vendor/libs/hammer/hammer.js"></script>

<script src="assets/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="assets/js/main.js"></script>

<!-- Page JS -->

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const btnExit = document.getElementById("btnExit");
    if (btnExit) {
      btnExit.addEventListener('click', () => {
        window.location.href = 'index.php';
      });
    }

    // Form button shortcuts and dynamic underlines
    const btnShortcuts = [
      { id: 'btnAdd', key: 'a', underlineHtml: '<u>A</u>dd' },
      { id: 'btnEdit', key: 'e', underlineHtml: '<u>E</u>dit' },
      { id: 'btnDelete', key: 'd', underlineHtml: '<u>D</u>elete' },
      { id: 'btnSave', key: 's', underlineHtml: '<u>S</u>ave' },
      { id: 'btnCancel', key: 'c', underlineHtml: '<u>C</u>ancel' },
      { id: 'btnExit', key: 'x', underlineHtml: 'E<u>x</u>it' },
      { id: 'btnSearch', key: 'h', underlineHtml: 'Searc<u>h</u>' },
      { id: 'btnPrint', key: 'p', underlineHtml: '<u>P</u>rint' }
    ];

    btnShortcuts.forEach(item => {
      const btn = document.getElementById(item.id);
      if (btn) {
        const icon = btn.querySelector('i');
        if (icon) {
          btn.innerHTML = icon.outerHTML + '<span>' + item.underlineHtml + '</span>';
        } else {
          btn.innerHTML = '<span>' + item.underlineHtml + '</span>';
        }
      }
    });

    // Keyboard shortcuts and arrow navigation for top-level menu items
    document.addEventListener('keydown', (e) => {
      // Ignore shortcuts if the user is typing in an input, textarea, select, or editable element
      const activeEl = document.activeElement;
      const isEditable = activeEl && (
        activeEl.tagName === 'INPUT' ||
        activeEl.tagName === 'TEXTAREA' ||
        activeEl.tagName === 'SELECT' ||
        activeEl.isContentEditable
      );

      // 1. Form Action Shortcuts (Alt + Key) - Allow even inside inputs!
      if (e.altKey && !e.ctrlKey && !e.shiftKey) {
        const key = e.key.toLowerCase();
        const shortcut = btnShortcuts.find(item => item.key === key);
        if (shortcut) {
          const btn = document.getElementById(shortcut.id);
          if (btn && !btn.disabled && btn.offsetWidth > 0 && btn.offsetHeight > 0) {
            e.preventDefault();
            btn.click();
            return;
          }
        }
      }

      // If user is editing text, don't trigger navigation / global menu shortcuts
      if (isEditable) {
        return;
      }

      // 2. Keyboard shortcuts (Ctrl + Key) for top-level menu
      if (e.ctrlKey && !e.altKey && !e.shiftKey) {
        const key = e.key.toLowerCase();
        let handled = false;

        if (key === 'm') {
          triggerMenuToggle('Master');
          handled = true;
        } else if (key === 'a') {
          triggerMenuToggle('Admin');
          handled = true;
        } else if (key === 'p') {
          triggerMenuToggle('Payroll');
          handled = true;
        } else if (key === 'r') {
          triggerMenuToggle('Reports');
          handled = true;
        } else if (key === 'u') {
          triggerMenuToggle('Utility');
          handled = true;
        } else if (key === 'e') {
          triggerMenuToggle('Exit');
          handled = true;
        }

        if (handled) {
          e.preventDefault();
          return;
        }
      }

      // 3. Arrow Key Navigation
      const openTopMenu = document.querySelector('#layout-menu .menu-inner > .menu-item.open');

      // Helper to get visible focusable links inside the currently open top menu
      const getVisibleLinks = () => {
        if (!openTopMenu) return [];
        const links = Array.from(openTopMenu.querySelectorAll('.menu-sub .menu-link'));
        return links.filter(link => link.offsetWidth > 0 && link.offsetHeight > 0);
      };

      if (openTopMenu) {
        const key = e.key;
        const visibleLinks = getVisibleLinks();
        const activeLinkIndex = visibleLinks.indexOf(activeEl);

        if (key === 'ArrowDown') {
          e.preventDefault();
          if (activeLinkIndex === -1) {
            if (visibleLinks.length > 0) visibleLinks[0].focus();
          } else {
            const nextIndex = (activeLinkIndex + 1) % visibleLinks.length;
            visibleLinks[nextIndex].focus();
          }
        } else if (key === 'ArrowUp') {
          e.preventDefault();
          if (activeLinkIndex === -1) {
            if (visibleLinks.length > 0) visibleLinks[visibleLinks.length - 1].focus();
          } else {
            const prevIndex = (activeLinkIndex - 1 + visibleLinks.length) % visibleLinks.length;
            visibleLinks[prevIndex].focus();
          }
        } else if (key === 'ArrowRight') {
          if (activeLinkIndex !== -1) {
            const activeLink = visibleLinks[activeLinkIndex];
            if (activeLink.classList.contains('menu-toggle')) {
              e.preventDefault();
              const parentItem = activeLink.closest('.menu-item');
              if (parentItem && !parentItem.classList.contains('open')) {
                activeLink.click();
                setTimeout(() => {
                  const updatedVisibleLinks = getVisibleLinks();
                  const index = updatedVisibleLinks.indexOf(activeLink);
                  if (index !== -1 && index + 1 < updatedVisibleLinks.length) {
                    updatedVisibleLinks[index + 1].focus();
                  }
                }, 100);
              }
            }
          }
        } else if (key === 'ArrowLeft') {
          if (activeLinkIndex !== -1) {
            const activeLink = visibleLinks[activeLinkIndex];
            const parentSub = activeLink.closest('.menu-sub');
            if (parentSub && parentSub.parentElement.closest('.menu-sub')) {
              e.preventDefault();
              const parentItem = parentSub.closest('.menu-item');
              if (parentItem) {
                const parentToggle = parentItem.querySelector('.menu-link.menu-toggle');
                if (parentToggle) {
                  parentToggle.click();
                  parentToggle.focus();
                }
              }
            }
          }
        }
      } else {
        // If no menu is open, but a top-level menu link has focus
        const isTopLevelLink = activeEl && activeEl.closest('.menu-inner') && !activeEl.closest('.menu-sub');
        if (isTopLevelLink && e.key === 'ArrowDown') {
          e.preventDefault();
          activeEl.click();
          setTimeout(() => {
            const newlyOpenedMenu = document.querySelector('#layout-menu .menu-inner > .menu-item.open');
            if (newlyOpenedMenu) {
              const links = Array.from(newlyOpenedMenu.querySelectorAll('.menu-sub .menu-link'));
              const visible = links.filter(link => link.offsetWidth > 0 && link.offsetHeight > 0);
              if (visible.length > 0) {
                visible[0].focus();
              }
            }
          }, 100);
        }
      }
    });

    function triggerMenuToggle(menuName) {
      const links = document.querySelectorAll('#layout-menu .menu-inner > .menu-item > .menu-link');
      links.forEach(link => {
        const div = link.querySelector('div[data-i18n]');
        if (div && div.getAttribute('data-i18n').trim().toLowerCase() === menuName.toLowerCase()) {
          link.click();
          // Focus the toggle link
          link.focus();
        }
      });
    }

    // Global Modal backdrop/overlap handling to hide draggableCard when any modal (search filter) shows
    document.addEventListener('show.bs.modal', function (event) {
      if (event.target.id === 'calculatorModal') return;
      const card = document.getElementById("draggableCard");
      if (card) {
        card.style.display = 'none';
      }
    });

    document.addEventListener('hidden.bs.modal', function (event) {
      if (event.target.id === 'calculatorModal') return;
      const card = document.getElementById("draggableCard");
      if (card) {
        card.style.display = 'block';
      }
    });

    // --- Calculator Implementation ---
    const btnOpenCalculator = document.getElementById("btnOpenCalculator");
    let calculatorModalInstance = null;
    if (btnOpenCalculator) {
      btnOpenCalculator.addEventListener('click', () => {
        const modalEl = document.getElementById("calculatorModal");
        if (modalEl) {
          if (!calculatorModalInstance) {
            calculatorModalInstance = new bootstrap.Modal(modalEl);
            // Setup dragging
            const dialog = modalEl.querySelector('.modal-dialog');
            const handle = modalEl.querySelector('.drag-handle');
            if (dialog && handle) {
              makeElementDraggable(dialog, handle);
            }
          }
          calculatorModalInstance.show();
        }
      });
    }

    let calcInput = '0';
    let calcResult = null;
    let calcOperator = null;
    let calcClearOnNext = false;

    function updateCalcDisplay() {
      const display = document.getElementById('calcDisplay');
      if (display) display.innerText = calcInput;
    }

    function handleCalcInput(val) {
      if ((val >= '0' && val <= '9') || val === '.') {
        if (calcInput === '0' || calcClearOnNext) {
          calcInput = val === '.' ? '0.' : val;
          calcClearOnNext = false;
        } else {
          if (val === '.' && calcInput.includes('.')) return;
          calcInput += val;
        }
      } else if (val === 'C') {
        calcInput = '0';
        calcResult = null;
        calcOperator = null;
        calcClearOnNext = false;
      } else if (val === 'CE') {
        calcInput = '0';
      } else if (val === 'Backspace') {
        calcInput = calcInput.slice(0, -1);
        if (calcInput === '' || calcInput === '-') calcInput = '0';
      } else if (val === '+-') {
        if (calcInput !== '0') {
          calcInput = calcInput.startsWith('-') ? calcInput.slice(1) : '-' + calcInput;
        }
      } else if (val === '%') {
        calcInput = String(parseFloat(calcInput) / 100);
      } else if (val === '1/x') {
        const num = parseFloat(calcInput);
        calcInput = num !== 0 ? String(1 / num) : 'Error';
        calcClearOnNext = true;
      } else if (val === 'x2') {
        const num = parseFloat(calcInput);
        calcInput = String(num * num);
        calcClearOnNext = true;
      } else if (val === 'sqrt') {
        const num = parseFloat(calcInput);
        calcInput = num >= 0 ? String(Math.sqrt(num)) : 'Error';
        calcClearOnNext = true;
      } else if (['+', '-', '*', '/'].includes(val)) {
        if (calcOperator && !calcClearOnNext) {
          calculateResult();
        }
        calcResult = parseFloat(calcInput);
        calcOperator = val;
        calcClearOnNext = true;
      } else if (val === '=') {
        calculateResult();
        calcOperator = null;
        calcClearOnNext = true;
      }
      updateCalcDisplay();
    }

    function calculateResult() {
      if (calcOperator === null || calcResult === null) return;
      const currentVal = parseFloat(calcInput);
      let finalVal = 0;
      switch (calcOperator) {
        case '+': finalVal = calcResult + currentVal; break;
        case '-': finalVal = calcResult - currentVal; break;
        case '*': finalVal = calcResult * currentVal; break;
        case '/': finalVal = currentVal !== 0 ? calcResult / currentVal : 'Error'; break;
      }
      calcInput = String(finalVal);
      calcResult = finalVal;
    }

    // Attach click events to calculator buttons
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('.calc-btn');
      if (btn) {
        const val = btn.getAttribute('data-val');
        handleCalcInput(val);
      }
    });

    // Attach keyboard listener when calculator is open
    document.addEventListener('keydown', (e) => {
      const modal = document.getElementById('calculatorModal');
      if (modal && modal.classList.contains('show')) {
        let key = e.key;
        if (key === 'Enter') key = '=';
        if (key === 'Escape') {
          if (calculatorModalInstance) calculatorModalInstance.hide();
          return;
        }
        if ((key >= '0' && key <= '9') || ['+', '-', '*', '/', '.', '=', 'Backspace'].includes(key)) {
          e.preventDefault();
          handleCalcInput(key);
        } else if (key.toLowerCase() === 'c') {
          e.preventDefault();
          handleCalcInput('C');
        }
      }
    });

    // Helper to make modal content draggable
    function makeElementDraggable(elmnt, handle) {
      let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
      if (handle) {
        handle.onmousedown = dragMouseDown;
      } else {
        elmnt.onmousedown = dragMouseDown;
      }

      function dragMouseDown(e) {
        e = e || window.event;
        if (['INPUT', 'BUTTON', 'A', 'SPAN'].includes(e.target.tagName)) return;
        e.preventDefault();
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        document.onmousemove = elementDrag;
      }

      function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
      }

      function closeDragElement() {
        document.onmouseup = null;
        document.onmousemove = null;
      }
    }
  });
</script>