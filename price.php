<?= $f_AdminCommon; ?>
<?
/* Выборка данных из двух таблиц по текущему каталогу для формирования цен */
$nc_core->db->query("SELECT s.Hidden_URL, m.hero_price, m.price_category, m.discription_price, m.dop_info_price, m.main_title, cp.price_category_Name 
FROM Message14 m
INNER JOIN Subdivision s INNER JOIN Classificator_price_category cp ON s.Catalogue_ID = " . $current_catalogue['Catalogue_ID'] . " AND s.Subdivision_ID = m.Subdivision_ID AND m.price_category != '' AND cp.price_category_ID = m.price_category");
$arr_price = $nc_core->db->last_result;

/* Проверка существующих категорий */
$array = [];
foreach ($arr_price as $item) {
  if (array_search($item->price_category_Name, $array) === false) {
    $array[] = $item->price_category_Name;
  }
}
?>
<? if ($arr_price) { ?>
  <section class="tabs-price tabs">
    <div class="tabs-price__tab">
      <? foreach ($array as $item) { ?>
        <button class="tabs-price__tab-links tab">
          <?= $item ?>
        </button>
      <? } ?>
    </div>
    <? foreach ($array as $item) { ?>
      <div class="tabs-price__tabcontent tab-content">
        <? foreach ($arr_price as $row) { ?>
          <? if ($row->price_category_Name == $item) { ?>
            <div class="tabs-price__tabcontent-wrap">
              <div class="tabs-price__tabcontent-name">
                <? if ($row->dop_info_price) { ?>
                  <div class="tabs-price__tabcontent-info tabs-price__tabcontent-info--mob"><?= $row->dop_info_price; ?></div>
                <? } ?>
                <div class="tabs-price__tabcontent-title">
                  <?= str_replace($current_catalogue['city2'], '', $row->main_title); ?>
                </div>
                <div class="tabs-price__tabcontent-discr">
                  <?= $row->discription_price; ?>
                </div>
              </div>
              <div class="tabs-price__tabcontent-blok">
                <div class="tabs-price__tabcontent-info tabs-price__tabcontent-info--desc">
                  <?= $row->dop_info_price; ?>
                </div>
                <div class="tabs-price__tabcontent-price">
                  <?= $row->hero_price; ?>
                </div>
                <div class="tabs-price__tabcontent-btns">
                  <div class="tabs-price__tabcontent-btn">
                    <a href="<?= $row->Hidden_URL; ?>">Подробнее</a>
                  </div>
                  <div class="tabs-price__tabcontent-btn">
                    <button class="header__btn btn btn_transparent popup-btn" data-path="form-call-4"
                      data-title="Обратный звонок">
                      Выбрать
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <? } ?>
        <? } ?>
      </div>
    <? } ?>
  </section>
<? } ?>
<script>
  // tabs цен
  const tabs = document.querySelectorAll('.tabs');

  if (tabs.length > 0) {
    tabs.forEach(elem => {
      const buttons = elem.querySelectorAll('.tab');
      const contents = elem.querySelectorAll('.tab-content');
      if (buttons.length > 0 && contents.length > 0) {
        for (let i = 0; i < buttons.length; i++) {
          buttons[i].addEventListener('click', () => {
            if (!buttons[i].classList.contains('active')) {
              buttons.forEach(element => {
                element.classList.remove('active');
              });
              contents.forEach(element => {
                element.classList.remove('tabs-price__tabcontent--active');
              });
              buttons[i].classList.add('active');
              contents[i].classList.add('tabs-price__tabcontent--active');
            }
          })
        }
        buttons[0].click();
      }
    })
  }
</script>