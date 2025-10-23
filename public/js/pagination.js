/**
 * @param {string} containerSelector 
 * @param {number} currentPage 
 * @param {number} totalPages  
 * @param {function} onPageClick
 */
function renderPaginationGlobal(
  containerSelector,
  currentPage,
  totalPages,
  onPageClick
) {
  const container = $(containerSelector);
  container.empty();

  if (totalPages <= 1) return;

  const pagination = $(
    '<ul class="pagination justify-content-center flex-wrap"></ul>'
  );
  const maxVisible = 5;

  function createItem(
    label,
    page,
    disabled = false,
    active = false,
    isIcon = false
  ) {
    const li = $('<li class="page-item"></li>');
    const a = $('<a class="page-link rounded-2" href="#"></a>');
    if (isIcon) a.html(label);
    else a.text(label);

    if (disabled) li.addClass("disabled");
    if (active) li.addClass("active bg-dark border-dark");

    a.on("click", function (e) {
      e.preventDefault();
      if (!disabled && !active) onPageClick(page);
    });

    li.append(a);
    return li;
  }

  pagination.append(
    createItem(
      '<i class="bi bi-chevron-double-left"></i>',
      1,
      currentPage === 1,
      false,
      true
    )
  );
  pagination.append(
    createItem(
      '<i class="bi bi-chevron-left"></i>',
      currentPage - 1,
      currentPage === 1,
      false,
      true
    )
  );

  let start = Math.max(1, currentPage - Math.floor(maxVisible / 2));
  let end = Math.min(totalPages, start + maxVisible - 1);
  if (end - start + 1 < maxVisible) {
    start = Math.max(1, end - maxVisible + 1);
  }

  if (start > 1) {
    pagination.append(createItem("1", 1, false, currentPage === 1));
    if (start > 2)
      pagination.append(
        $(
          '<li class="page-item disabled"><span class="page-link rounded-2">…</span></li>'
        )
      );
  }

  for (let i = start; i <= end; i++) {
    pagination.append(createItem(i, i, false, i === currentPage));
  }

  if (end < totalPages) {
    if (end < totalPages - 1)
      pagination.append(
        $(
          '<li class="page-item disabled"><span class="page-link rounded-2">…</span></li>'
        )
      );
    pagination.append(
      createItem(totalPages, totalPages, false, currentPage === totalPages)
    );
  }

  pagination.append(
    createItem(
      '<i class="bi bi-chevron-right"></i>',
      currentPage + 1,
      currentPage === totalPages,
      false,
      true
    )
  );
  pagination.append(
    createItem(
      '<i class="bi bi-chevron-double-right"></i>',
      totalPages,
      currentPage === totalPages,
      false,
      true
    )
  );

  container.append(pagination);
}
