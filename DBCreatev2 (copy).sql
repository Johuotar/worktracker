/* usefull scripts */


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

