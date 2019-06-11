/* usefull scripts */
/* VS 2019-05-22: Asiakkaan henkilöstö */
SELECT a.henkiloID, concat(a.sukunimi, ' ',a.etunimi) as Nimi, a.sposti
FROM henkilo a
WHERE a.asiakasID=2 /* $asiakasID */
and exists(select 1 from henkilo ab where a.asiakasID=ab.asiakasID and ab.henkiloID=11 /* $henkiloID */);


/* VS 2019-05-22: asiakashenkilön projektinäkymän haku */
SELECT a.projektiID, a.asiakasID, a.henkiloID
,concat(c.sukunimi, ' ',c.etunimi) as ProjektiPaallikko
,a.projekti, a.alkuPvm, a.loppuPvm, a.arkistointiPvm
FROM projekti a
inner join asiakas b on (a.asiakasID=b.asiakasID)
inner join henkilo c on (a.henkiloID=c.henkiloID)
inner join asiakas cc on (c.asiakasID=cc.asiakasID)
inner join henkilonRooli e on (c.henkiloID=e.henkiloID and cc.asiakasID=e.asiakasID)
inner join rooli f on (e.rooliID=f.rooliID)
WHERE a.asiakasID=2 /* $asiakasID */
and b.tyyppi='T'
and cc.tyyppi='O'
and f.rooli='Projektipäällikkö'
and exists(select 1 from henkilo ab where a.asiakasID=ab.asiakasID and ab.henkiloID=11 /* $henkiloID */)
;


/* VS 2019-05-22: asiakashenkilön projektin tehtävän näkymän haku */
SELECT a.projektinTehtavaID, a.asiakasID, a.projektiID
,aa.projekti
,a.henkiloID, concat(c.sukunimi, ' ',c.etunimi) as Tyontekija, 
a.tehtava, a.alkuPvm, a.loppuPvm
,a.tehtavanStatus, a.hyvaksymisPvm, a.arkistointiPvm
FROM projektinTehtava a
inner join projekti aa on (a.projektiID=aa.projektiID and a.asiakasID=aa.asiakasID)
inner join asiakas b on (a.asiakasID=b.asiakasID)
inner join henkilo c on (a.henkiloID=c.henkiloID)
inner join asiakas cc on (c.asiakasID=cc.asiakasID)
inner join henkilonRooli e on (c.henkiloID=e.henkiloID and cc.asiakasID=e.asiakasID)
inner join rooli f on (e.rooliID=f.rooliID)
WHERE a.asiakasID=2 /* $asiakasID */
and b.tyyppi='T' /* tilaaja*/
and cc.tyyppi='O' /* oma yritys */
and f.rooli='Työntekijä'
and exists(select 1 from henkilo ab where a.asiakasID=ab.asiakasID and ab.henkiloID=11 /* $henkiloID */)
;
 /* **********  */


SELECT /* a.asiakasID, */
a.nimi as AsiakkaanNimi
/* ,a.tyyppi as asiakkaanTyyppi */
,case when (a.tyyppi='O') then ('Oma Yritys') 
when (a.tyyppi='T') then ('Tilaajan Yritys') 
else ('Ei tiedossa')
end as AsiakkaanTyyppi
,b.Etunimi, b.Sukunimi
,f.rooli as HenkilonRooli
,c.kayttajatunnus, c.salasana
FROM asiakas a
inner join henkilo b on (a.asiakasID=b.asiakasID)
inner join kayttaja c on (b.sposti=c.kayttajatunnus)
inner join henkilonRooli e on (a.asiakasID=e.asiakasID and b.henkiloID=e.henkiloID)
inner join rooli f on (e.rooliID=f.rooliID)
WHERE a.asiakasID=b.asiakasID
and a.asiakasID=e.asiakasID
;



/*  2019-06-11 */
/* ei kayteta skandeja roolien koodauksessa */
UPDATE `rooli` 
SET `rooli`='Projektipaallikko'
WHERE `rooliID`=1;

UPDATE `rooli` 
SET `rooli`='Tyontekija'
WHERE `rooliID`=2;



/* tarkennetaan PP:n projektien hakua, Omassa vastuussa */
const sqlLause1 = "SELECT aa.* FROM projekti aa
	 inner join henkilo a on (aa.henkiloId=a.henkiloId)
         inner join asiakas b on (a.asiakasID=b.asiakasID)
         inner join henkilonRooli c on (a.henkiloId=c.henkiloId)
         inner join rooli e on (c.rooliId=e.rooliId)
         where b.tyyppi='O' 
         and e.rooli='Projektipaallikko' 
	 and a.henkiloID=1" + connection.escape(henkiloID);
	 and a.asiakasID=1




Oma henkilöstö
Projektipäälliköt

const sqlLausePPaallikot = "SELECT a.henkiloId, concat(a.sukunimi, ' ', a.etunimi) as Nimi"
         + " FROM henkilo a" 
         + " inner join asiakas b on (a.asiakasID=b.asiakasID)"
         + " inner join henkilonRooli c on (a.henkiloId=c.henkiloId)"
         + " inner join rooli e on (c.rooliId=e.rooliId)"
         + " where b.tyyppi='O'" 
         + " and e.rooli='Projektipaallikko'"
	 + " and a.asiakasID="  + connection.escape(asiakasID)
	 + " and exists(select 1 from henkilo aa where a.asiakasID=aa.asiakasID and a.henkiloId=" + connection.escape(henkiloID) + '")"
         ;



